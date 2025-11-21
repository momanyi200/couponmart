@extends('layouts.admin')

@section('content')

    {{-- Prevent modal flash --}}
    <style>[x-cloak] { display: none !important; }</style>

    <div class="p-4" x-data="{ open: false, profileId: null }">

        <h2 class="text-xl font-bold mb-4">All User Profiles</h2>

        <form method="GET" action="{{ route('user-profiles.index') }}" class="mb-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded shadow">

                <!-- Search -->
                <div>
                    <label class="text-sm font-semibold">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Name, Phone, Email..."
                           class="w-full border rounded p-2">
                </div>

                <!-- Town -->
                <div>
                    <label class="text-sm font-semibold">Town</label>
                    <select name="town_id" class="w-full border rounded p-2">
                        <option value="">All Towns</option>
                        @foreach($towns as $town)
                            <option value="{{ $town->id }}" {{ request('town_id') == $town->id ? 'selected' : '' }}>
                                {{ $town->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Gender -->
                <div>
                    <label class="text-sm font-semibold">Gender</label>
                    <select name="gender" class="w-full border rounded p-2">
                        <option value="">All</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="text-sm font-semibold">Status</label>
                    <select name="status" class="w-full border rounded p-2">
                        <option value="">All</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="blacklisted" {{ request('status') == 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                </div>

            </div>

            <div class="mt-4 flex gap-2">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
                <a href="{{ route('user-profiles.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Reset</a>
            </div>

        </form>

        <hr class="my-3"/>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4">

            @foreach($profiles as $profile)
                <div class="bg-white shadow rounded-lg p-4">

                    <!-- Image -->
                    <div class="flex justify-center mb-3">
                        @if($profile->image)
                            <img src="{{ asset('assets/users/'.$profile->image) }}"
                                 class="w-20 h-20 rounded-full object-cover shadow">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                No Image
                            </div>
                        @endif
                    </div>

                    <!-- Name & Email -->
                    <h3 class="text-lg font-semibold text-center">
                        {{ $profile->first_name }} {{ $profile->last_name }}
                    </h3>

                    <p class="text-center text-sm text-gray-500">
                        {{ $profile->user->email ?? 'No User Email' }}
                    </p>

                    <div class="mt-4 space-y-1 text-center">
                        <p><span class="font-medium">Phone:</span> {{ $profile->phone_number }}</p>
                        <p><span class="font-medium">Town:</span> {{ $profile->town->name ?? 'N/A' }}</p>
                        <p><span class="font-medium">Gender:</span> {{ ucfirst($profile->gender) }}</p>

                        <!-- Status Badge -->
                        <p>Status:
                            <span class="px-2 py-1 text-white rounded text-sm
                                {{ $profile->status == 'active' ? 'bg-green-600' :
                                ($profile->status == 'pending' ? 'bg-yellow-500' : 'bg-red-600') }}">
                                {{ ucfirst($profile->status) }}
                            </span>
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 flex justify-between items-center">

                        <a href="{{ route('profiles.show', $profile) }}"
                           class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            View
                        </a>

                        @if($profile->status === 'blacklisted')

                            <form action="{{ route('user-profiles.toggle-status', $profile->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                    Unblacklist
                                </button>
                            </form>

                        @else

                            <button
                                @click="open = true; profileId = {{ $profile->id }}"
                                class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                Blacklist
                            </button>

                        @endif

                    </div>

                </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $profiles->links() }}
        </div>

        <!-- Blacklist Modal -->
        <div x-show="open" x-cloak
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

            <div class="bg-white w-96 p-6 rounded shadow-lg">
                <h2 class="text-lg font-bold mb-3">Blacklist User</h2>

                <form method="POST" :action="'/user-profiles/' + profileId + '/toggle-status'">
                    @csrf
                    @method('PATCH')

                    <label class="block mb-2 font-semibold">Reason</label>
                    <textarea name="reason" class="w-full border rounded p-2" rows="3"
                              placeholder="Enter reason (optional)"></textarea>

                    <div class="flex justify-end gap-2 mt-4">

                        <button type="button"
                                @click="open=false"
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
