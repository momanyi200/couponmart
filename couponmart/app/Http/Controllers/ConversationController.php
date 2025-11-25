<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();

    //     if ($user->hasRole('admin')) {
    //         // Admin sees all conversations
    //         $conversations = Conversation::with(['participants', 'messages' => fn($q) => $q->latest()->limit(1)])
    //             ->orderBy('updated_at', 'desc')
    //             ->paginate(20);
    //     } elseif ($user->hasRole('business')) {
    //         // Seller sees conversations linked to orders where they're the seller
    //         $conversations = Conversation::whereHas('participants', fn($q) => $q->where('user_id', $user->id))
    //             ->with(['participants', 'messages' => fn($q) => $q->latest()->limit(1)])
    //             ->orderBy('updated_at', 'desc')
    //             ->paginate(20);
    //     } else {
    //         // buyer / normal user sees own conversations
    //         $conversations = $user->conversations()
    //             ->with(['participants', 'messages' => fn($q) => $q->latest()->limit(1)])
    //             ->orderBy('updated_at', 'desc')
    //             ->paginate(20);
    //     }

    //     return view('backend.messages.index', compact('conversations'));
    // }

    // public function index()
    // {
    //     $user = Auth::user();
    //     //dd($user->business->id);
    //     if ($user->hasRole('admin')) {

    //         // ADMIN → sees all conversations
    //         $conversations = Conversation::with([
    //                 'participants.user',
    //                 'messages' => fn($q) => $q->latest()->limit(1),
    //                 'order'
    //             ])
    //             ->orderBy('updated_at', 'desc')
    //             ->paginate(20);

    //     } elseif ($user->hasRole('business')) {

    //         // SELLER → sees conversations where they are the order's seller
    //         $conversations = Conversation::whereHas('order', function ($q) use ($user) {
    //                 $q->where('seller_id', $user->id);
    //             })
    //             ->with([
    //                 'participants',
    //                 'messages' => fn($q) => $q->latest()->limit(1),
    //                 'order'
    //             ])
    //             ->orderBy('updated_at', 'desc')
    //             ->paginate(20);
               


    //     } else {

    //         // BUYER → sees conversations they participate in
    //         $conversations = $user->conversations()
    //             ->with([
    //                 'participants.user',
    //                 'messages' => fn($q) => $q->latest()->limit(1),
    //                 'order'
    //             ])
    //             ->orderBy('updated_at', 'desc')
    //             ->paginate(20);
    //     }

    //     return view('backend.messages.index', compact('conversations'));
    // }

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {

            // ADMIN → sees all conversations (but only those with messages)
            $conversations = Conversation::whereHas('messages')
                ->with([
                    'participants',
                    'messages' => fn($q) => $q->latest()->limit(1),
                    'order'
                ])
                ->orderBy('updated_at', 'desc')
                ->paginate(20);

        } elseif ($user->hasRole('business')) {

            // SELLER → sees conversations where they are the order's seller
            $conversations = Conversation::whereHas('order', function ($q) use ($user) {
                    $q->where('seller_id', $user->id);
                })
                ->whereHas('messages') // ⬅️ ensure conversation has at least one message
                ->with([
                    'participants',
                    'messages' => fn($q) => $q->latest()->limit(1),
                    'order'
                ])
                ->orderBy('updated_at', 'desc')
                ->paginate(20);

        } else {

            // BUYER → sees conversations they participate in
            $conversations = $user->conversations()
                ->whereHas('messages') // ⬅️ ensure conversation has messages
                ->with([
                    'participants',
                    'messages' => fn($q) => $q->latest()->limit(1),
                    'order'
                ])
                ->orderBy('updated_at', 'desc')
                ->paginate(20);
        }

        return view('backend.messages.index', compact('conversations'));
    }


    public function show(Conversation $conversation)
    {
        // authorize handled by route middleware
        $conversation->load(['participants', 'messages.sender']);

        // mark unread messages as read for current user
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('backend.messages.show', compact('conversation'));
    }

    public function startAdminConversation(Request $request)
    {
        $user = Auth::user();

        // Check if the user already has an admin conversation
        $conversation = Conversation::where('is_admin_chat', true)
            ->whereHas('participants', fn($q) => $q->where('user_id', $user->id))
            ->first();

        // If no conversation exists, create a new one
        if (!$conversation) {
            $conversation = Conversation::create([
                'is_admin_chat' => true,
                'started_by' => $user->id, // Optional: track who started it
            ]);

            // Attach the user and all admins
            $admins = User::role('admin')->pluck('id')->toArray();
            $conversation->participants()->sync(array_merge([$user->id], $admins));
        }

        // Redirect to the conversation
        return redirect()->route('conversations.show', $conversation);
    }

    // Optional: create conversation when an order is placed
    public function createForOrder(Order $order)
    {
        // only create if not existing
        $conversation = Conversation::firstOrCreate([
            'order_id' => $order->id,
            'is_admin_chat' => false,
        ]);

        // attach participants if not attached
        $participants = [$order->user_id];
        if ($order->business_id) {
            $participants[] = $order->business_id;
        }
        $conversation->participants()->syncWithoutDetaching($participants);

        return response()->json(['conversation_id' => $conversation->id], 201);
    }

    public function start(Order $order)
    {
        $user = auth()->user();

        // Only the buyer can start chat
        if ($order->user_id !== $user->id) {
            abort(403);
        }

        // Check if conversation exists already
        $conversation = Conversation::firstOrCreate([
            'order_id' => $order->id,
        ]);

        // Attach participants (buyer + seller) if not yet added
        $conversation->participants()->syncWithoutDetaching([
            $order->user_id,       // buyer
            $order->seller_id,     // seller
        ]);

        return redirect()->route('conversations.show', $conversation->id);
    }

}
