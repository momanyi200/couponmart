@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 shadow rounded">

    <h2 class="text-xl font-bold mb-4">Order Lookup</h2>

    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-2 mb-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ route('order.check') }}" class="space-y-4">

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Enter Order Number</label>
            <input type="text" name="code" class="w-full border p-2 rounded"
                   placeholder="e.g. ORD-985732" required>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Search Order
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        Or scan the QR code attached to the customer's receipt.
    </div>

</div>
@endsection
