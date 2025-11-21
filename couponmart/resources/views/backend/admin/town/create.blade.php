@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto mt-6">
    <h1 class="text-xl font-bold mb-4">Add Town</h1>

    <form action="{{ route('towns.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="town_name" class="block text-gray-700 font-semibold">Town Name</label>
            <input type="text" name="town_name" id="town_name" value="{{ old('town_name') }}"
                   class="w-full p-2 mt-2 border-gray-300 rounded focus:ring focus:ring-blue-200" required>
            @error('town_name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
        <a href="{{ route('towns.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection
