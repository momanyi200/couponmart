@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Messages</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="col-span-1 bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between mb-3"> 
                <h2 class="font-medium">Inbox</h2>
                <form method="POST" action="{{ route('conversations.admin.start') }}">
                    @csrf
                    <button class="text-sm px-2 py-1 rounded bg-blue-600 text-white">Contact Admin</button>
                </form>
            </div>

            <ul>
                @forelse($conversations as $conv)
                   
                    @php
                        $other = $conv->participants->firstWhere('id', '<>', auth()->id());
                        $latest = $conv->messages->first();
                        $unreadCount = $conv->messages
                            ->where('is_read', false)
                            ->where('sender_id', '!=', auth()->id())
                            ->count();
                    @endphp

                    <li class="mb-3">
                        <a href="{{ route('conversations.show', $conv) }}" class="flex items-center p-2 rounded hover:bg-gray-50">

                            <div class="flex-1">

                                {{-- OTHER PARTICIPANT NAME --}}
                                <div class="font-medium">
                                    {{ $other?->display_name ?? 'Unknown User' }}

                                    @if($unreadCount)
                                        <span class="ml-2 inline-block bg-red-500 text-white text-xs px-2 py-0.5 rounded">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>

                                {{-- ORDER INFO --}}
                                @if($conv->order)
                                    <div class="text-xs text-gray-600">
                                        About Order: 
                                        <span class="font-semibold">
                                            #{{ $conv->order->order_number ?? $conv->order->id }}
                                        </span>

                                        @if($conv->order->product)
                                            – {{ \Illuminate\Support\Str::limit($conv->order->product->title, 40) }}
                                        @endif
                                    </div>
                                @endif

                                {{-- LAST MESSAGE --}}
                                <div class="text-sm text-gray-500">
                                    {{ $latest?->message ? \Illuminate\Support\Str::limit($latest->message, 60) : 'No messages yet' }}
                                </div>
                            </div>

                            <div class="text-xs text-gray-400">
                                {{ $conv->updated_at->diffForHumans() }}
                            </div>

                        </a>
                    </li>


                @empty
                    <li>No conversations yet.</li>
                @endforelse
            </ul>

            <div class="mt-4">{{ $conversations->links() }}</div>
        </div>

        <div class="col-span-2 bg-white rounded-lg shadow p-4">
            <p class="text-gray-500">Select a conversation to view messages.</p>
        </div>
    </div>
</div>
@endsection
