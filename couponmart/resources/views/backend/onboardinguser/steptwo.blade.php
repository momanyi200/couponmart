@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    
    <!-- Header Section -->
    <div class="text-center mb-8">
        <h3 class="text-2xl font-bold text-gray-800">KouponCity Registration Process</h3>
        <p class="text-gray-500">Step 2: Complete the form below to sign up</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow-lg rounded-xl p-8">
        <form method="POST" action="{{ route('saveusersteptwo') }}">
            @csrf

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6">
                    @foreach ($errors->all() as $error)
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-2">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- First Name -->
            <div class="mb-5">
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input id="first_name" 
                       type="text" 
                       name="first_name" 
                       value="{{ old('first_name') }}"
                       required
                       placeholder="Type your first name"
                       class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('first_name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-5">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input id="last_name" 
                       type="text" 
                       name="last_name"
                       value="{{ old('last_name') }}"
                       placeholder="Type your last name"
                       class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('last_name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="mb-5">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input id="phone_number" 
                       type="text" 
                       name="phone_number" 
                       value="{{ old('phone_number') }}"
                       placeholder="e.g., 0712345678"
                       class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Gender --> 
            <div class="mb-5">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" 
                        name="gender" 
                        class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Select Gender</option>
                    @foreach($gender as $g)
                        <option value="{{ $g->id }}" {{ old('gender') == $g->id ? 'selected' : '' }}>
                            {{ $g->gender_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Town -->
            <div class="mb-5">
                <label for="town" class="block text-sm font-medium text-gray-700">Town</label>
                <select id="town" 
                        name="town_id" 
                        class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Select Town</option>
                    @foreach($town as $t)
                        <option value="{{ $t->id }}" {{ old('town') == $t->id ? 'selected' : '' }}>
                            {{ $t->town_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    Proceed to Step Three
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
