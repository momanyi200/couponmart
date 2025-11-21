@extends('layouts.admin')

@section('content')

@php
    $mindate = date("Y-m-d");
@endphp

<div class="px-8 py-6">
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Physical Location</h3>
    </div>

    <div>
        {{-- Error messages --}}
        @if ($errors->any())
            <div class="space-y-2 mb-4">
                @foreach ($errors->all() as $error)
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded flex justify-between items-center">
                        <span>{{ $error }}</span>
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('savelocation') }}" class="space-y-5 bg-white p-6 rounded shadow">
        @csrf

        {{-- Building --}}
        <div>
            <label for="building" class="block text-sm font-medium text-gray-700 mb-1">Building Name</label>
            <input 
                type="text" 
                name="building" 
                id="building" 
                value="{{ old('building', $business->building) }}" 
                class="w-full p-2 rounded border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
        </div>

        {{-- Floor --}}
        <div>
            <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">Floor</label>
            <input 
                type="text" 
                name="floor" 
                id="floor" 
                value="{{ old('floor', $business->floor) }}" 
                class="w-full p-2 rounded border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
        </div>

        {{-- Room --}}
        <div>
            <label for="room" class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
            <input 
                type="text" 
                name="room" 
                id="room" 
                value="{{ old('room', $business->room) }}" 
                class="w-full p-2 rounded border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
        </div>

        {{-- Submit --}}
        <div>
            <button 
                type="submit" 
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
            >
                Submit
            </button>
        </div>
    </form>
</div>

@endsection
