@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-xl font-bold mb-4">Create Coupon</h1>
    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @include('backend.coupons.form', [
            'coupon' => null,
            'categories' => $categories,
            'mindate' => now()->toDateString(),
        ])
    </form>
</div>
@endsection

