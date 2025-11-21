<?php

// app/Http/Controllers/Admin/CouponController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Business;
use App\Models\CouponSuspension;
use Illuminate\Http\Request;
use Auth;
use App\Services\PhotoService;
use Illuminate\Auth\Access\AuthorizationException;

class CouponController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();

        if ($role === 'admin') {
            // Admin sees pending coupons for all active businesses
            $businessIds = Business::where('status', 'active')->pluck('id');
        } else {
            // Normal user sees pending coupons for their business only
            $businessIds = [Auth::user()->business->id];
        }

        $coupons = Coupon::with('categories') // eager load categories
                    ->whereIn('business_id', $businessIds)
                    ->where('status', 'active')
                    ->paginate(20);

        return view('backend.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.coupons.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            //'categories'=>'required',
            'cost'=>'required|numeric|min:1',
            'details'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'total_vouchers'=>'required',
        ]);
        $business = Auth::user()->business;

        $coupon = Coupon::create([
            
            'title'=>$request->title,
           // 'categories'=>$request->'required',
            'cost'=>$request->cost,
            'details'=>$request->details,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'total_vouchers'=>$request->total_vouchers,
            'remaining_vouchers'=>$request->total_vouchers,
            'business_id'=>$business->id
        ]); 

        $coupon->categories()->attach($request->categories);

        return redirect()->route('admin.coupons.addimage',$coupon->id)->with('success', 'Coupon created successfully, you can proceed to adding an image of the coupon.');
    }

    public function edit(Coupon $coupon)
    {
        $categories = Category::all();
        $couponCategories = $coupon->categories->first();
        
        return view('backend.coupons.edit', compact('categories', 'couponCategories','coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'title'=>'required',
            //'categories'=>'required',
            'cost'=>'required|numeric|min:1',
            'details'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'total_vouchers'=>'required',
        ]);

        $coupon->update([
            'code' => $request->code,
            'discount' => $request->discount,
            'rerun' => $request->rerun,
        ]);

        $coupon->categories()->sync($request->categories);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->categories()->detach();
        $coupon->delete();

        return redirect()->route('backend.coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    public function underreviewed(){

        $role = Auth::user()->getRoleNames()->first();

        if ($role === 'admin') {
            // Admin sees pending coupons for all active businesses
            $businessIds = Business::where('status', 'active')->pluck('id');
        } else {
            // Normal user sees pending coupons for their business only
            $businessIds = [Auth::user()->business->id];
        }
    
        $coupons = Coupon::with('categories') // eager load categories
                    ->whereIn('business_id', $businessIds)
                    ->where('status', 'under review')
                    ->paginate(20);

        return view('backend.coupons.reviewed',compact('coupons'));        
    }

    public function pendingcoupons()
    {
        $role = Auth::user()->getRoleNames()->first();

        if ($role === 'admin') {
            // Admin sees pending coupons for all active businesses
            $businessIds = Business::where('status', 'active')->pluck('id');
        } else {
            // Normal user sees pending coupons for their business only
            $businessIds = [Auth::user()->business->id];
        }
    
        $coupons = Coupon::with('categories') // eager load categories
                    ->whereIn('business_id', $businessIds)
                    ->where('status', 'pending')
                    ->paginate(20);

        return view('backend.coupons.pending', compact('coupons'));
    }

    public function addimage($id){

        return view('backend.coupons.addimage',compact('id'));
    }

    public function save_image(Request $request, $id)
    {
        $request->validate([
            'base64' => ['required', 'string', 'regex:/^data:image\/(png|jpg|jpeg);base64,/',],
        ]);

        $coupon = Coupon::with('business')->findOrFail($id);

        if ($coupon->business->user_id !== auth()->id()) {
            abort(403, 'Unauthorized — you do not own this coupon');
        }

        try {
            $photoService = new PhotoService();
            $outputDir = 'assets/coupons/';
            $imageName = $photoService->decodeBase64($request->base64, $outputDir);

            $coupon->update([
                'image' => $imageName,
                'status' => 'under review'
            ]);

            return redirect()->route('admin.coupons.index')
                            ->with('success', 'The upload was successful');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Image upload failed: ' . $e->getMessage()]);
        }
    }

    public function suspend(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $coupon = Coupon::findOrFail($id);

         // Security check: Only admin or owner can suspend
        if (!auth()->user()->hasRole('admin') && auth()->id() !== $coupon->business->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $coupon->status = 'suspended';
        $coupon->save();

        CouponSuspension::create([
            'coupon_id' => $coupon->id,
            'user_id'   => auth()->id(),
            'reason'    => $request->reason,
            'suspended_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Coupon suspended successfully.');
    }

    public function activate($id)
    {
        $coupon = Coupon::findOrFail($id);

        $lastSuspension = $coupon->suspensions()->whereNull('lifted_at')->latest()->first();

        if (!$lastSuspension) {
            return redirect()->back()->with('error', 'This coupon is not currently suspended.');
        }

        // Restrict lifting logic
        $user = auth()->user();

        // Case 1: owner suspended their own coupon
        if ($lastSuspension->user_id === $coupon->business->user_id) {
            if ($user->id !== $lastSuspension->user_id) {
                return redirect()->back()->with('error', 'Only the owner who suspended this coupon can lift it.');
            }
        }
        // Case 2: admin suspended the coupon
        elseif ($lastSuspension->user->hasRole('admin')) {
            if (!$user->hasRole('admin')) {
                return redirect()->back()->with('error', 'Only an admin can lift this suspension.');
            }
        }
        // Case 3: some other user suspended it
        else {
            if ($user->id !== $lastSuspension->user_id) {
                return redirect()->back()->with('error', 'Only the person who suspended this coupon can lift it.');
            }
        }

        // ✅ If passed checks → reactivate
        $coupon->status = 'active';
        $coupon->save();

        $lastSuspension->update(['lifted_at' => now()]);

        return redirect()->back()->with('success', 'Coupon re-activated successfully.');
    }


    public function approve(Coupon $coupon)
    {
        try {
            // ✅ Ensure only admins can approve
            if (!Auth::user()->hasRole('admin')) {
                throw new AuthorizationException('You are not authorized to approve coupons.');
            }

            // ✅ Approve coupon
            $coupon->status = 'active';
            $coupon->save();

            return redirect()->back()->with('success', 'Coupon was approved successfully.');
        } catch (AuthorizationException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            // Catch unexpected errors
            return redirect()->back()->with('error', 'Something went wrong while approving the coupon.');
        }
    }

    public function suspendedCoupons()
    {
        $user = auth()->user();

        $query = Coupon::with(['suspensions' => function ($q) {
            $q->whereNull('lifted_at'); // only active suspensions
        }])->where('status', 'suspended');

        if (!$user->hasRole('admin')) {
            // Non-admin → only their coupons
            $query->whereHas('business', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $coupons = $query->get();

        return view('backend.coupons.suspended', compact('coupons'));
    }

    public function maturedAndExpiredCoupons()
    {
        $user = auth()->user();

        $query = Coupon::whereIn('status', ['matured', 'expired']);

        // Restrict non-admins to only their own coupons
        if (!$user->hasRole('admin')) {
            $query->whereHas('business', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $coupons = $query->with('business')->get();

        return view('backend.coupons.matured_expired', compact('coupons'));
    }

    public function rerun(Coupon $coupon){ 

       $user = auth()->user();

        // If user is NOT an admin, make sure the coupon belongs to their business
    
        if ($coupon->business->user_id !== $user->id) {
            abort(403, 'You are not authorized to rerun this coupon.');
        }    
        
        return view('backend.coupons.rerun',compact('coupon'));
    }

    public function savererun(Coupon $coupon, Request $request)
    {
        // Validate request input
        $validatedData = $request->validate([
            'id' => 'required|exists:coupons,id',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Find the original coupon
       return $coupon = Coupon::findOrFail($request->id);

        // Mark the original coupon as rerun
        $coupon->rerun = true;
        $coupon->save();

        // Clone the coupon into a new instance
        $newCoupon = $coupon->replicate();   // makes a full copy of attributes
        $newCoupon->status = 'active';       // reset status for rerun
        $newCoupon->rerun = false;           // fresh rerun coupon
        $newCoupon->start_date = $request->start_date;
        $newCoupon->end_date = $request->end_date;
        $newCoupon->created_at = now();      // fresh timestamps
        $newCoupon->updated_at = now();
        $newCoupon->save();

        return redirect()->route('admin.coupons.index')
            ->with("success", "Coupon rerun successfully.");
    }







}
