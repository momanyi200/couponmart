@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-8">

    <h2 class="text-xl font-bold mb-4">Add New System Charge</h2>

    <form method="POST" action="{{ route('system-charges.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Category</label>
            <select name="cat_id" class="w-full border rounded p-2">
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Percentage (%)</label>
            <input type="text" name="percentage"
                   class="w-full border rounded p-2"
                   placeholder="e.g. 5">
            @error('percentage')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
            Save Charge
        </button>
    </form>

</div>
@endsection
