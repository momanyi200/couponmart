@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-6"
     x-data="{ openBlacklistModal:false }">

    <!-- Back Button -->
    <a href="{{ route('user-profiles.index') }}"
       class="inline-block mb-4 text-blue-600 hover:underline">
        ← Back to Profiles
    </a>

    <!-- Profile Header -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">

        <div class="flex items-center">
            <!-- Image -->
            <div class="w-28 h-28 rounded-full overflow-hidden border shadow">
                @if($profile->image)
                    <img src="{{ asset('assets/users/'.$profile->image) }}"
                         class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}"
                         class="w-full h-full object-cover">
                @endif
            </div>

            <!-- Info -->
            <div class="ml-6 flex-1">
                <h2 class="text-2xl font-bold">
                    {{ $profile->first_name }} {{ $profile->last_name }}
                </h2>

                <p class="text-gray-600">
                    {{ $profile->user->email ?? 'No Email' }}  
                </p>

                <p class="text-gray-600">
                    Phone: {{ $profile->phone_number }}
                </p>

                <p class="text-gray-600">
                    Town: {{ $profile->town->name ?? 'N/A' }}
                </p>

                <p class="text-gray-600 capitalize">
                    Gender: {{ $profile->gender }}
                </p>

                <!-- Status Badge -->
                <p class="mt-2">
                    <span class="
                        px-3 py-1 rounded text-white text-sm
                        {{ $profile->status == 'active' ? 'bg-green-600' : ($profile->status == 'pending' ? 'bg-yellow-500' : 'bg-red-600') }}
                    ">
                        {{ ucfirst($profile->status) }}
                    </span>
                </p>
            </div>

            <!-- Actions -->
            <div class="text-right">

                <!-- ==========================
                     EDIT BUTTON LOGIC
                     ========================== -->
                @php
                    $loggedUser = auth()->user();
                    $profileOwner = $profile->user_id === $loggedUser->id;
                    $isAdmin = $loggedUser->hasRole('admin');
                    $isCustomer = $profile->user->hasRole('customer');
                @endphp

                @if(($profileOwner && $isCustomer))
                    <a href="{{ route('user-profiles.edit', $profile->id) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 block mb-3">
                        Edit Profile
                    </a>
                @endif

                <!-- Blacklist / Unblacklist Button -->
                @if($profile->status === 'blacklisted')

                    <!-- Unblacklist -->
                    <form action="{{ route('user-profiles.toggle-status', $profile->id) }}"
                          method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full">
                            Unblacklist
                        </button>
                    </form>

                @else

                    <!-- Open Blacklist Modal -->
                    <button
                        @click="openBlacklistModal = true"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 w-full">
                        Blacklist User
                    </button>

                @endif
            </div>
        </div>
    </div>



    <!-- Blacklist Logs -->
    <div class="bg-white shadow rounded-lg p-6">

        <h3 class="text-xl font-semibold mb-4">Blacklist History</h3>

        @if($profile->blacklistLogs->count() == 0)
            <p class="text-gray-500">No blacklist activity found.</p>
        @else

            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Action</th>
                        <th class="p-2 border">Reason</th>
                        <th class="p-2 border">Admin</th>
                        <th class="p-2 border">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profile->blacklistLogs as $log)
                        <tr>
                            <td class="p-2 border capitalize">{{ $log->action }}</td>
                            <td class="p-2 border">{{ $log->reason ?? '—' }}</td>
                            <td class="p-2 border">{{ $log->admin->name ?? 'System' }}</td>
                            <td class="p-2 border">{{ $log->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @endif

    </div>





    <!-- ======================================================
         Blacklist Modal (Now Works Because x-data Wraps Page)
         ====================================================== -->
    <style>[x-cloak] { display:none !important; }</style>

    <div x-show="openBlacklistModal" x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div class="bg-white w-96 p-6 rounded shadow-lg">

            <h2 class="text-lg font-bold mb-3">Blacklist User</h2>

            <form method="POST" action="{{ route('user-profiles.toggle-status', $profile->id) }}">
                @csrf
                @method('PATCH')

                <label class="block mb-2 font-semibold">Reason (optional)</label>
                <textarea name="reason"
                          class="w-full border rounded p-2"
                          rows="3"
                          placeholder="Enter reason"></textarea>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button"
                            @click="openBlacklistModal=false"
                            class="px-3 py-2 bg-gray-500 text-white rounded">
                        Cancel
                    </button>

                    <button class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Blacklist
                    </button>
                </div>
            </form>

        </div>

    </div>


</div>

@endsection
