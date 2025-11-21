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

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-3">Category</th>
                    <th class="p-3">Percentage</th>
                    <th class="p-3">Added By</th>
                    <th class="p-3">Created</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($charges as $charge)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $charge->category->cat_name }}</td>
                        <td class="p-3">{{ $charge->percentage }}%</td>
                        <td class="p-3">{{ $charge->user->name ?? 'N/A' }}</td>
                        <td class="p-3">{{ $charge->created_at->format('d M Y') }}</td>

                        <td class="p-3 text-right">
                            <a href="{{ route('system-charges.edit', $charge->id) }}"
                               class="text-blue-600 hover:underline mr-3">Edit</a>

                            <form method="POST"
                                  action="{{ route('system-charges.destroy', $charge->id) }}"
                                  class="inline-block"
                                  onsubmit="return confirm('Delete this charge?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $charges->links() }}
    </div>
</div>
@endsection
