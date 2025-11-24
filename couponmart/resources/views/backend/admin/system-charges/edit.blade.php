@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-8">

    <h2 class="text-xl font-bold mb-6">Edit System Charge</h2>

    <form method="POST" action="{{ route('system-charges.update', $charge->id) }}">
        @csrf
        @method('PUT')

        {{-- CATEGORY --}}
        <div class="mb-5">
            <label class="block font-semibold mb-1">Category</label>
            <select name="cat_id" class="w-full border rounded p-2">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ $charge->cat_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->cat_name }}
                    </option>
                @endforeach
            </select>
            @error('cat_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- SYSTEM PERCENTAGE --}}
        <div class="mb-5">
            <label class="block font-semibold mb-1">System Percentage (%)</label>
            <input 
                type="number" 
                name="percentage"
                step="0.01"
                min="0"
                value="{{ old('percentage', $charge->percentage) }}"
                class="w-full border rounded p-2"
            >
            @error('percentage')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CASHBACK PERCENTAGE --}}
        <div class="mb-5">
            <label class="block font-semibold mb-1">Cashback Percentage (%)</label>
            <input 
                type="number" 
                name="cashback_percentage"
                step="0.01"
                min="0"
                value="{{ old('cashback_percentage', $charge->cashback_percentage) }}"
                class="w-full border rounded p-2"
            >
            @error('cashback_percentage')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button 
            class="bg-blue-600 text-white px-5 py-2 rounded shadow hover:bg-blue-700">
            Update Charge
        </button>

    </form>

</div>
@endsection
