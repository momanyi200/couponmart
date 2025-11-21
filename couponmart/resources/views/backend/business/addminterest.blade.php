@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <!-- Heading -->
    <h3 class="text-center text-2xl font-bold mb-8">Select More Categories</h3>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-100 text-green-800 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 px-4 py-3 bg-red-100 text-red-800 border border-red-300 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ url('save/myinterest') }}" method="POST" class="bg-white shadow rounded p-6">
        @csrf

        @if($categories->isEmpty())
            <p class="text-gray-600 text-center">No more categories are available to select.</p>
        @else
            <!-- Category List -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                @foreach($categories as $cat)
                    <div class="flex items-center space-x-2">
                        <input 
                            type="checkbox" 
                            id="cat-{{ $cat->id }}" 
                            name="categories[]" 
                            value="{{ $cat->id }}" 
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <label for="cat-{{ $cat->id }}" class="text-gray-700">
                            {{ $cat->cat_name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                    class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 transition">
                    Submit
                </button>
            </div>
        @endif
    </form>
</div>
@endsection
