<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = CartItem::with('coupon')->where('user_id', auth()->id())->get();
        $total = $items->sum(fn($item) => $item->price * $item->quantity);

        return view('backend.cart.index', compact('items', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $item)
    {
        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $item)
    {
        $item->delete();

        return back()->with('success', 'Item removed!');
    }

    public function addToCart(Request $request)
    {
        $product = Coupon::findOrFail($request->coupon_id);
        
        $item = CartItem::where('user_id', auth()->id())
            ->where('coupon_id', $product->id)
            ->first();

        if ($item) {
            $item->quantity += $request->quantity ?? 1;
            $item->save();
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'coupon_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
                'price' => $product->cost,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

}
