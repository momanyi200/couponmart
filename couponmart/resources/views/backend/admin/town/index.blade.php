@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto mt-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Towns</h1>
        <a href="{{ route('towns.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
            Add Town
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($towns->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($towns as $town)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">
                            {{ $town->town_name }}
                        </h2>
                        <p class="text-sm text-gray-500">Town ID: {{ $town->id }}</p>
                    </div>
                    
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('towns.edit', $town) }}" 
                           class="flex-1 px-3 py-2 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Edit
                        </a>
                        <form action="{{ route('towns.destroy', $town) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Delete this town?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-500 text-center mt-10">
            No towns have been added yet.
        </div>
    @endif
</div>
@endsection
