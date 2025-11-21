<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Business;
use App\Models\Town;
use Auth; 
use Carbon\Carbon;

class PagesController extends Controller
{
    //
    public function index(){
        
        $categories = Category::limit(5)->get();
        $coupons = Coupon::where('status', 'active')->latest()->take(6)->get();

        $businesses = Business::where('status', 'active')
                      ->latest()
                      ->take(6) // Limit for homepage
                      ->get();

        return view ('pages.index',compact('businesses','categories','coupons'));
    }

    public function coupons()
    {
        //$categories = Category::all();
        $today = Carbon::now();

        $coupons = Coupon::where('status', 'active')
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $today);
            })
            ->latest()
            ->paginate(12);

        $categories = Category::all();
          $towns =Town::all();    

        return view('pages.coupons', compact('coupons','categories','towns'));
    }

    public function business(){
          $categories = Category::all();
          $towns =Town::all();
          $businesses = Business::where('status', 'active')
                      ->latest()
                      ->take(6) // Limit for homepage
                      ->paginate(15);

        return view('pages.business',compact('businesses','categories','towns'));              
    }

    public function categoriesCoupon($id){
        $category = Category::findOrFail($id);

        // Fetch coupons under this category
       $coupons = $category->coupons()
                    ->where('status', 'active')   // optional
                    ->latest()
                    ->paginate(12);
        $categories = Category::all();
        $towns =Town::all();
        return view('pages.categoriescoupon', compact('category', 'coupons','categories','towns'));
    }

    public function profile($slug)
    {
        // Fetch business by slug (or id if that's what you use)
        $business = Business::where('id', $slug)
            ->with([
                // 'products' => function($q) {
                //     $q->latest()->take(8); // show recent 8 products
                // },
                'coupons' => function($q) {
                    $q->where('status', 'active')->latest();
                },
                //'reviews.user'
            ])
            ->firstOrFail();
         $town=$business->town;   

        return view('pages.businessprofile', compact('business','town'));
    }

    public function coupondetails(Coupon $coupon){
        
        // If you want to load related business info
        $coupon->load('business');

         // Fetch related coupons in the same category
        $relatedCoupons = Coupon::whereHas('categories', function ($query) use ($coupon) {
                $query->whereIn('categories.id', $coupon->categories->pluck('id'));
            })
            ->where('id', '!=', $coupon->id)
            ->take(4)
            ->get();


        return view('pages.couponsdetails', compact('coupon','relatedCoupons'));

    }
}
