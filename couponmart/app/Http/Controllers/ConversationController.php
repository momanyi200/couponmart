<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin sees all conversations
            $conversations = Conversation::with(['participants', 'messages' => fn($q) => $q->latest()->limit(1)])
                ->orderBy('updated_at', 'desc')
                ->paginate(20);
        } elseif ($user->hasRole('business')) {
            // Seller sees conversations linked to orders where they're the seller
            $conversations = Conversation::whereHas('participants', fn($q) => $q->where('user_id', $user->id))
                ->with(['participants', 'messages' => fn($q) => $q->latest()->limit(1)])
                ->orderBy('updated_at', 'desc')
                ->paginate(20);
        } else {
            // buyer / normal user sees own conversations
            $conversations = $user->conversations()
                ->with(['participants', 'messages' => fn($q) => $q->latest()->limit(1)])
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

        // single admin conversation per user, or create new depending on your policy
        $conversation = Conversation::firstOrCreate(
            ['is_admin_chat' => true],
            []
        );

        // Attach the user and all admins (so any admin can reply)
        $admins = User::role('admin')->pluck('id')->toArray();

        $conversation->participants()->syncWithoutDetaching(array_merge([$user->id], $admins));

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
        if ($order->seller_id) {
            $participants[] = $order->seller_id;
        }
        $conversation->participants()->syncWithoutDetaching($participants);

        return response()->json(['conversation_id' => $conversation->id], 201);
    }
}
