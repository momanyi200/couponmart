@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto mt-8 bg-white shadow rounded-lg p-6">
    <h1 class="text-xl font-bold mb-4">Add New Category</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="cat_name" class="block font-medium mb-1">Category Name</label>
            <input type="text" name="cat_name" id="cat_name" value="{{ old('cat_name') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
        </div>
    </form>
</div>
@endsection
