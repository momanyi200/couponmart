@extends('layouts.admin')

@section('content')
@php
    $mindate = date("Y-m-d");
    $starts = date("Y-m-d", strtotime($coupon->start_date));
    $endss = date("Y-m-d", strtotime($coupon->end_date));
@endphp

<div class="max-w-4xl mx-auto py-8">
    <h3 class="text-center text-2xl font-semibold mb-6">Rerun this Coupon</h3>

    <div class="bg-white shadow rounded-2xl p-6">
        
        <form method="post" action="{{ route('admin.coupons.savererun',$coupon)}}" class="space-y-6">
            @csrf
            {{-- Coupon Title --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Coupon Title</label>
                <p class="text-lg font-semibold text-gray-900">{{$coupon->title}}</p>
            </div>

             {{-- Valid From & End Date --}}
            <div class="grid grid-cols-1 my-2 sm:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Valid From</label>
                    <input type="date" name="start_date" id="start_date" min="{{ $mindate }}"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ $starts }}">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" min="{{ $mindate }}"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ $endss }}">
                </div>
            </div>

           

            {{-- Submit --}}
            <div class="text-center">
                <button type="submit" class='px-6 py-2 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 transition' > Submit </button>              
            </div>

        </form>
    </div>
</div>
@endsection
