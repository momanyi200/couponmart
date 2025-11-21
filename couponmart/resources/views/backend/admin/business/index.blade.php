@extends('layouts.admin')

@section('content') 

@php
    $role = Auth::user()->getRoleNames()->first();
@endphp 

<div class="max-w-7xl mx-auto p-6">
    <h3 class="text-2xl font-bold text-start mb-6">Businesses Listed in the System</h3>

    @if($businesses->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded text-start">
            <strong>You don't have any data currently available.</strong>
        </div>
    @else
       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($businesses as $item)
                <div class="bg-white rounded-lg shadow p-5 flex flex-col justify-between">
                    <div>
                        <h5 class="text-lg font-semibold mb-1">{{ $item->business_name }}</h5>
                        <p class="text-sm text-gray-600 mb-4">Status: {{ ucfirst($item->status) }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-auto">
                        <a href="{{ route('business.show', $item->id) }}" 
                           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            View Profile
                        </a>
                        <a href="#" 
                           class="px-3 py-1 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                            View Activities
                        </a>

                        @if(!empty($item->verified) && $item->status == 'pending')
                            <a href="{{ route('admin.verify', $item->id) }}" 
                               class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                Verify Business
                            </a>
                        @endif

                        @if($item->status != 'blacklisted' && !empty($item->verified))
                            <button 
                                @click="openSuspend({{ $item->id }})" 
                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                Suspend Business
                            </button>
                        @endif
                        @if($item->status == 'blacklisted' && !empty($item->verified))
                            <button 
                                @click="openLift('{{ url('admin/business/lift', $item->id) }}')" 
                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                Lift Suspension
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Lift Suspension Modal -->
    <div 
        x-show="showLift" 
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
        x-transition.opacity
        style="display:none"
    >
        <div class="bg-white rounded shadow-lg w-full max-w-md p-6 text-center" x-transition.scale>
            <h4 class="text-lg font-semibold mb-4">
                Are you sure you want to lift the suspension on this business?
            </h4>
            <div class="flex justify-center gap-3">
                <a :href="liftUrl" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Proceed
                </a>
                <button type="button" @click="showLift = false" 
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Suspend Business Modal -->
    <div 
        x-show="showSuspend" 
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
        x-transition.opacity
        style="display:none"
    >
        <div class="bg-white rounded shadow-lg w-full max-w-md p-6" x-transition.scale>
            <h4 class="text-lg font-semibold mb-4">Koupon City: Suspension Request</h4>
            <form method="post" action="{{ route('business.suspend') }}">
                @csrf
                <div class="mb-4">
                    <label for="reason" class="block font-medium">Detailed Reason</label>
                    <textarea name="reason" rows="3"
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Provide the reason for suspension"
                              required></textarea>
                    <input type="hidden" name="business_id" :value="suspendId">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Submit
                    </button>
                    <button type="button" @click="showSuspend = false" 
                            class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
