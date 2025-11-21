<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class OrderLookupController extends Controller
{
    //
    public function form()
    {
        return view('backend.orders.lookup');
    }

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $order = Order::with('items.coupon')
            ->where('order_number', $request->code)
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found.');
        }

        if (!$order->qr_active && $order->status === 'redeemed') {
            return back()->with('error', 'This order has already been redeemed.');
        }              

        return view('backend.orders.show-business', compact('order'));

    }

   
}
