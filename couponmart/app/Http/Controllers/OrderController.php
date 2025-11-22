<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\WalletTransaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $user = Auth::user();

        $orders = Order::query()
            // Admin sees all; normal user sees only their own orders
            ->when(!$user->hasRole('admin'), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })

            // Status filter
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })

            // From date filter
            ->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            })

            // To date filter
            ->when(request('to'), function ($query) {
                $query->whereDate('created_at', '<=', request('to'));
            })

            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('backend.orders.index', compact('orders'));
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
   
    public function show(Order $order)
    {
        // Load related items and coupon details
        $order->load('items.coupon');

        // Ensure QR exists
        if (!file_exists(public_path($order->qr_code_path))) {
            return redirect()->back()->with('error', 'QR code file is missing.');
        }

        return view('backend.orders.show', compact('order'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

   
    public function downloadPdf(Order $order)
    {
        $order->load('items.coupon');

        $pdf = Pdf::loadView('backend.orders.pdf', [
            'order' => $order
        ]);

        $fileName = $order->order_number . '.pdf';

        return $pdf->download($fileName);
    }
 
       

    public function redeem(Order $order)
    {
        if ($order->status === 'redeemed') {
            return back()->with('info', 'Order has already been redeemed.');
        }

        DB::beginTransaction();

        try {

            // -------------------------------
            // 1. CUSTOMER WALLET CHECK
            // -------------------------------
            $customer = $order->user;
            $customerWallet = $customer->wallet ?? Wallet::create([
                'user_id' => $customer->id,
                'balance' => 0,
            ]);

            if ($customerWallet->balance < $order->total) {
                return back()->with('error', 'Customer does not have enough wallet balance to pay for this order.');
            }

            // Deduct wallet
            $customerWallet->balance -= $order->total;
            $customerWallet->save();

            // Log transaction
            WalletTransaction::create([
                'wallet_id'   => $customerWallet->id,
                'amount'      => -$order->total,
                'type'        => 'payment',
                'description' => "Payment for Order #{$order->order_number}",
            ]);

            // -------------------------------
            // 2. SYSTEM WALLET
            //-------------------------------
            $systemWallet = Wallet::system();
            if (!$systemWallet) {
                $systemWallet = Wallet::create([
                    'is_system' => true,
                    'balance'   => 0,
                ]);
            }

            $totalCashback = 0;

            // -------------------------------
            // 3. LOOP ITEMS: SELLER PAYOUTS + REDUCE COUPON STOCK
            // -------------------------------
            foreach ($order->items as $item) {

                $sellerEarning = $item->seller_earning ?? ($item->price * 0.90);
                $systemCut     = $item->system_cut ?? ($item->price * 0.10);

                // Seller payout
                $seller = $item->coupon->business->user ?? null;
                if ($seller) {
                    $sellerWallet = $seller->wallet ?? Wallet::create([
                        'user_id' => $seller->id,
                        'balance' => 0,
                    ]);

                    $sellerWallet->balance += $sellerEarning;
                    $sellerWallet->save();

                    WalletTransaction::create([
                        'wallet_id' => $sellerWallet->id,
                        'amount' => $sellerEarning,
                        'type' => 'seller_earning',
                        'reference' => "Earning from Order #{$order->order_number}, Item #{$item->id}",
                        'status' => 'paid',
                    ]);
                }

                // System commission
                $systemWallet->balance += $systemCut;
                $systemWallet->save();

                WalletTransaction::create([
                    'wallet_id' => $systemWallet->id,
                    'amount' => $systemCut,
                    'type' => 'system_commission',
                    'reference' => "System commission from Order #{$order->order_number}, Item #{$item->id}",
                    'status' => 'paid',
                ]);

                // Reduce coupon stock
                $coupon = $item->coupon;
                if ($coupon) {
                    $coupon->remaining_vouchers = max(0, $coupon->remaining_vouchers - $item->quantity);
                    $coupon->save();
                }

                // -------------------------------
                // 3D. CALCULATE CASHBACK PER ITEM
                // -------------------------------
                $cashbackAmount = $item->cashback_amount ?? 0;
                $totalCashback += $cashbackAmount;
            }

            // -------------------------------
            // 4. CREDIT CASHBACK TO CUSTOMER WALLET
            // -------------------------------
            if ($totalCashback > 0) {
                WalletTransaction::create([
                    'wallet_id' => $customerWallet->id,
                    'amount' => $totalCashback,
                    'type' => 'cashback',
                    'description' => "Cashback from redeemed Order #{$order->order_number}",
                ]);

                $customerWallet->increment('balance', $totalCashback);
            }

            // -------------------------------
            // 5. UPDATE ORDER
            // -------------------------------
            $order->update([
                'status'        => 'redeemed',
                'redeemed_by'   => auth()->id(),
                'redeemed_at'   => now(),
                'qr_active'     => false,
                'paid_via_wallet' => true,
                'paid_amount'     => $order->total,
            ]);

            DB::commit();

            // -------------------------------
            // 6. SEND EMAIL (optional)
            // -------------------------------
            if ($order->user && $order->user->email) {
                \Mail::to($order->user->email)
                    ->send(new \App\Mail\OrderRedeemed($order));
            }

            return redirect()
                ->route('dashboard')
                ->with('success', 'Order redeemed, wallets updated, coupon stock reduced, and cashback credited.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error redeeming order: ' . $e->getMessage());
        }
    }





}
