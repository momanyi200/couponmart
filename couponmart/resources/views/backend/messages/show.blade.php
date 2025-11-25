@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold">
                    Conversation
                </h2>
                <div class="text-sm text-gray-500">
                    Participants:
                    @foreach($conversation->participants as $p)
                        {{ $p->display_name }}@if(!$loop->last),@endif
                    @endforeach
                </div>
            </div>
            <div class="text-sm text-gray-400">{{ $conversation->updated_at->diffForHumans() }}</div>
        </div>

        <div id="messages" class="h-96 overflow-y-auto border rounded p-4 mb-4">
            @foreach($conversation->messages as $message)
                <div class="mb-3">
                    <div class="flex items-start {{ $message->sender_id === auth()->id() ? 'justify-end' : '' }}">
                        <div class="{{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white rounded-tl-lg rounded-bl-lg rounded-br-lg px-4 py-2' : 'bg-gray-100 text-gray-800 rounded-tr-lg rounded-bl-lg px-4 py-2' }}" style="max-width:70%;">
                            <div class="text-xs text-gray-600 mb-1">{{ $message->sender->name }} · <span class="text-gray-400">{{ $message->created_at->format('M d, H:i') }}</span></div>
                            <div class="whitespace-pre-wrap">{{ $message->message }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <form id="sendMessageForm" action="{{ route('conversations.messages.store', $conversation) }}" method="POST">
            @csrf
            <div class="flex gap-2">
                <textarea id="messageInput" name="message" rows="2" class="flex-1 border rounded p-2" placeholder="Type your message..."></textarea>
                <button id="sendBtn" type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Send</button>
            </div>
        </form>
    </div>
</div>
<!-- 
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('sendMessageForm');
        const input = document.getElementById('messageInput');
        const messagesEl = document.getElementById('messages');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const body = input.value.trim();
            if (!body) return;

            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ message: body })
            });

            if (!res.ok) {
                alert("Failed to send message.");
                return;
            }

            const data = await res.json();
            const msg = data.message;

            // append new message bubble
            const wrapper = document.createElement('div');
            wrapper.classList.add("mb-3");
            wrapper.innerHTML = `
                <div class="flex items-start justify-end">
                    <div class="bg-blue-600 text-white rounded-tl-lg rounded-bl-lg rounded-br-lg px-4 py-2 max-w-[70%]">
                        <div class="text-xs text-gray-200 mb-1">
                            You · ${new Date(msg.created_at).toLocaleString()}
                        </div>
                        <div>${msg.message.replace(/\n/g, '<br>')}</div>
                    </div>
                </div>
            `;

            messagesEl.appendChild(wrapper);
            messagesEl.scrollTop = messagesEl.scrollHeight;
            input.value = '';
        });

    });
</script> -->


@endsection
