@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">System Charges</h1>
        <a href="{{ route('system-charges.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
            + Add Charge
        </a> 
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($charges as $charge)
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition duration-200">
                <h2 class="text-lg font-bold mb-2">{{ $charge->category->cat_name }}</h2>
                <p><span class="font-semibold">System Fee:</span> {{ $charge->percentage }}%</p>
                <p><span class="font-semibold">Cashback:</span> {{ $charge->cashback_percentage }}%</p>
                <p><span class="font-semibold">Added By:</span> {{ $charge->user->name ?? 'N/A' }}</p>

                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('system-charges.edit', $charge->id) }}"
                       class="text-blue-600 hover:underline">Edit</a>

                    <form method="POST"
                          action="{{ route('system-charges.destroy', $charge->id) }}"
                          onsubmit="return confirm('Delete this charge?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $charges->links() }}
    </div>

</div>
@endsection
