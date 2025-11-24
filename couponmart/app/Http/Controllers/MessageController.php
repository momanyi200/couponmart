<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        

        // route middleware already authorizes access
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        // extra role checks:
        if (!$conversation->is_admin_chat) {
            if (!auth()->user()->hasAnyRole(['customer', 'business'])) {
                abort(403);
            }
        }

        // business users (sellers) cannot chat unless linked to an order
        if (auth()->user()->hasRole('business') && $conversation->order_id === null) {
            abort(403);
        }


        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        // update conversation updated_at for ordering
        $conversation->touch();

        // Notify all participants except the sender
        $participants = $conversation->participants()->where('user_id', '!=', Auth::id())->get();
        foreach ($participants as $participant) {
            $participant->notify(new NewMessageNotification($message));
        }

        // if AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'ok',
                'message' => $message->load('sender'),
            ]);
        }

        return back()->with('success', 'Message sent');
    }
}
