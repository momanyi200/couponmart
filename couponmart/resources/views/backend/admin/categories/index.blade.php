@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto mt-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Categories</h1>
        <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add Category</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($categories as $category)
            <div class="bg-white border rounded-lg shadow p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold">{{ $category->cat_name }}</h2>
                </div>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('categories.edit', $category) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">No categories found.</p>
        @endforelse
    </div>
</div>
@endsection
