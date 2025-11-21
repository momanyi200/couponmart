@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-8">

    <h2 class="text-xl font-bold mb-4">Edit System Charge</h2>

    <form method="POST" action="{{ route('system-charges.update', $charge->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Category</label>
            <select name="cat_id" class="w-full border rounded p-2">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ $charge->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->cat_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Percentage (%)</label>
            <input type="text" name="percentage"
                   value="{{ $charge->percentage }}"
                   class="w-full border rounded p-2">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
            Update Charge
        </button>

    </form>

</div>
@endsection
