@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-xl font-bold mb-4">Edit Coupon</h1>
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
        @method('PUT')
        @include('backend.coupons.form', [
            'coupon' => $coupon,
            'categories' => $categories,
            'couponCategories' => $couponCategories,
            'mindate' => date("Y-m-d"),
            'starts' => date("Y-m-d",strtotime($coupon->start_date)),
            'endss' => date("Y-m-d",strtotime($coupon->end_date)),
        ])
    </form> 
</div>
@endsection
