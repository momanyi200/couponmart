@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Stats Cards --}}
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-sm text-gray-500">Total Users</h2>
        <p class="text-2xl font-bold">1,245</p>
    </div>
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-sm text-gray-500">Revenue</h2>
        <p class="text-2xl font-bold">$12,430</p>
    </div>
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-sm text-gray-500">New Orders</h2>
        <p class="text-2xl font-bold">320</p>
    </div>
</div>

{{-- Placeholder for Chart --}}
<div class="mt-6 bg-white p-6 shadow rounded">
    <h3 class="font-semibold mb-4">Sales Overview</h3>
    <div class="h-64 bg-gray-50 flex items-center justify-center text-gray-400">
        Chart Placeholder
    </div>
</div>
@endsection
