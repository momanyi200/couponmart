@extends('layouts.admin')

@section('content')

@php
    use Illuminate\Support\Facades\Auth;
    $role = Auth::user()->getRoleNames()->first();       
@endphp 

<div class="space-y-10">
    <!-- Categories Header -->
    <div>
        <h2 class="text-2xl font-bold mb-6">My Categories</h2>

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b border-gray-300 pb-3 mb-4">
           
            @if(count($business_category) < 4)
                <a href="{{ url('add/myinterest') }}" target="_blank" 
                   class="inline-block mt-3 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Add New Category
                </a>
            @endif
        </div>
    </div>

    <!-- Categories List -->
    <div class="space-y-4">
        @forelse($business_category as $post)
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between border rounded p-4 hover:shadow-sm transition">
                <!-- Category Name -->
                <a href="{{ url('/couponcategories/' . $post->cat_id) }}" 
                class="text-gray-800 hover:text-blue-600 font-medium">
                    {{ $post->cat_name }}
                </a>

                <!-- Actions -->
                <div class="mt-3 md:mt-0">
                    <a href="{{ url('remove/myinterest/' . $post->id) }}" 
                    title="Remove this category"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Remove
                    </a>
                </div>
            </div>
        @empty
            <a href="{{ url('add/myinterest') }}" target="_blank" 
            class="inline-block mt-3 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Add New Category
            </a>
        @endforelse

    </div>
</div>

@endsection
