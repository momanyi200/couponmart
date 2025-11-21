@extends('layouts.app')

@section('title', 'Business Verification')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Step 2: Updating Business Profile</h2>

    <form method="POST" action="{{ route('onboarding.stage2.store') }}">
        @csrf

        
        {{-- Short Bio / Description --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Short Bio / Description</label>
            <textarea name="bios" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('bios') }}</textarea>
            @error('bios')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <hr class="my-4"/>

        {{-- Categories --}}
        <div class="mb-4">
            <p class="text-center font-semibold mb-3">Select the categories your business is involved in</p>
            <div class="grid grid-cols-2 gap-3">
                @foreach($categories as $category) 
                    <label class="flex items-center space-x-2 border border-gray-200 rounded px-3 py-2 hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                               class="w-4 h-4 text-green-600 border-gray-300 rounded"
                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                        <span>{{ $category->cat_name }}</span>
                    </label>
                @endforeach
            </div>
            @error('categories')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="text-center">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
               Proceed To Step Three
            </button>
        </div>
    </form>
</div>
@endsection
