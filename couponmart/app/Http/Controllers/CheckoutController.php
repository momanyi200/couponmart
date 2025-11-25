<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SystemCharge;
use App\Models\Business;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CheckoutController extends Controller
{
    // 
    

    // public function checkout()
    // {
    //     try { 

    //         $userId = auth()->id();

    //         // Fetch cart items
    //         $items = CartItem::with('coupon')->where('user_id', $userId)->get();
    //         if ($items->isEmpty()) {
    //             return back()->with('error', 'Your cart is empty.');
    //         }

    //         // Calculate total
    //         $total = $items->sum(fn($i) => $i->price * $i->quantity);

    //         DB::beginTransaction(); 

    //         // Create order
    //         $order = Order::create([
    //             'user_id' => $userId,
    //             'order_number' => 'CM-' . Str::upper(Str::random(10)),
    //             'total' => $total,
    //         ]);

    //         // Create order items
    //         foreach ($items as $item) {
               
    //             $charge = $item->coupon->systemCharge();
    //             $cashbackPercentage = $charge->cashback_percentage ?? 0;
    //             $percentage = $charge->percentage ?? 0;
    //             $price = $item->price * $item->quantity;
    //             $systemCut = ($percentage / 100) * $price;
    //             $sellerEarning = $price - $systemCut;
    //             $cashbackAmount = ($systemCut * $cashbackPercentage) / 100;

    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'coupon_id' => $item->coupon_id,
    //                 'quantity' => $item->quantity,
    //                 'price'    => $item->price,
    //                 'system_cut'     => $systemCut,
    //                 'seller_earning' => $sellerEarning,
    //                 'cashback_amount' => $cashbackAmount,
    //             ]);
    //         }

    //         // Clear cart
    //         CartItem::where('user_id', $userId)->delete();

    //         DB::commit();

    //         // Generate QR in a second try block because it uses files
    //         try {
    //             $qrDir = public_path('qr');

    //             if (!file_exists($qrDir)) {
    //                 mkdir($qrDir, 0777, true);
    //             }

    //             $fileName = 'qr_' . $order->order_number . '.png';
    //             $filePath = $qrDir . '/' . $fileName;

    //             $lookupUrl = route('order.check', [
    //                 'code' => $order->order_number
    //             ]);

    //             QrCode::format('png')
    //                 ->size(300)
    //                 ->generate($lookupUrl, $filePath);

    //             $order->update([
    //                 'qr_code_path' => 'qr/' . $fileName
    //             ]);

    //         } catch (\Exception $qrError) {
    //             Log::error('QR Code generation failed: ' . $qrError->getMessage());

    //             // Continue without failing the whole order
    //             return redirect()
    //                 ->route('orders.show', $order->id)
    //                 ->with('warning', 'Order created but QR code could not be generated.');
    //         }

    //         return redirect()->route('orders.show', $order->id);

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         Log::error('Checkout failed: ' . $e->getMessage(), [
    //             'user_id' => auth()->id()
    //         ]);

    //         return back()->with('error', 'Something went wrong while processing your order.');
    //     }
    // }

    public function checkout()
    {
        try {
            $userId = auth()->id();

            // Fetch cart items
            $items = CartItem::with('coupon.business')->where('user_id', $userId)->get();
            if ($items->isEmpty()) {
                return back()->with('error', 'Your cart is empty.');
            }

            // Group items BY BUSINESS
            $grouped = $items->groupBy('coupon.business_id');

            //dd($grouped);
           // return Business::find($grouped);
            $createdOrders = [];

            DB::beginTransaction();

            foreach ($grouped as $businessId => $businessItems) {

                // Calculate total for this business
                $total = $businessItems->sum(fn($i) => $i->price * $i->quantity);
                $seller_id= Business::find($businessId)->user_id;
                // Create order for THIS business
                $order = Order::create([
                    'user_id'       => $userId,
                    'seller_id'   => $seller_id,
                    'order_number'  => 'CM-' . Str::upper(Str::random(10)),
                    'total'         => $total,
                ]);

                // Create order items
                foreach ($businessItems as $item) {
                    $charge = $item->coupon->systemCharge();
                    $cashbackPercentage = $charge->cashback_percentage ?? 0;
                    $percentage = $charge->percentage ?? 0;

                    $price = $item->price * $item->quantity;
                    $systemCut = ($percentage / 100) * $price;
                    $sellerEarning = $price - $systemCut;
                    $cashbackAmount = ($systemCut * $cashbackPercentage) / 100;

                    OrderItem::create([
                        'order_id'        => $order->id,
                        'coupon_id'       => $item->coupon_id,
                        'quantity'        => $item->quantity,
                        'price'           => $item->price,
                        'system_cut'      => $systemCut,
                        'seller_earning'  => $sellerEarning,
                        'cashback_amount' => $cashbackAmount,
                    ]);
                }

                $createdOrders[] = $order;
            }

            // Clear cart (only AFTER all orders succeed)
            CartItem::where('user_id', $userId)->delete();

            DB::commit();

            // ------------------------------------------------------
            // QR generation in a separate loop (outside transaction)
            // ------------------------------------------------------

            foreach ($createdOrders as $order) {
                try {
                    $qrDir = public_path('qr');

                    if (!file_exists($qrDir)) {
                        mkdir($qrDir, 0777, true);
                    }

                    $fileName = 'qr_' . $order->order_number . '.png';
                    $filePath = $qrDir . '/' . $fileName;

                    $lookupUrl = route('order.check', [
                        'code' => $order->order_number
                    ]);

                    QrCode::format('png')
                        ->size(300)
                        ->generate($lookupUrl, $filePath);

                    $order->update([
                        'qr_code_path' => 'qr/' . $fileName
                    ]);

                } catch (\Exception $qrError) {
                    Log::error('QR Code generation failed: ' . $qrError->getMessage());
                }
            }

            // If only 1 order → redirect to order page
            if (count($createdOrders) == 1) {
                return redirect()->route('orders.show', $createdOrders[0]->id);
            }

            // If multiple orders → show a summary page
            return view('orders.multiple', [
                'orders' => $createdOrders
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Checkout failed: ' . $e->getMessage(), [
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Something went wrong while processing your order.');
        }
    }



}
