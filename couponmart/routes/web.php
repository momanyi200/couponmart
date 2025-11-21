<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SystemChargeController;
use App\Http\Controllers\OrderLookupController;
use App\Http\Controllers\WalletController;


Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('coupons',[PagesController::class, 'coupons'])->name('coupons.index');
Route::get('business',[PagesController::class, 'business'])->name('business.index');
Route::get('coupon-categories/{coupon}',[PagesController::class, 'categoriesCoupon'])->name('categories.coupon');
Route::get('/coupons/{coupon}', [PagesController::class, 'coupondetails'])->name('coupons.show');
// routes/web.php
Route::get('/business/{slug}', [PagesController::class, 'profile'])->name('business.show');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'register'])->name('register.store');


Route::middleware(['auth', 'role:customer'])->group(function () {
    
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/cart', [CartItemController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartItemController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{item}', [CartItemController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartItemController::class, 'destroy'])->name('cart.remove');

    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout'); 
    
   


});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin-only routes

   //Route::get('buss/suspendcoupon/{status}',[voucherController::class,'busssuspendcoup'])->name('adminsuspendcoup'); 
    
    Route::post('admin/suspendkoupons/{id}',[CouponController::class,'suspendcoupons']);  
    Route::get('admin/suspenddetails/{id}',[CouponController::class,'suspenddetails']);
    Route::get('admin/liftcouponsuspention/{id}',[CouponController::class,'liftcouponsuspention']);

    Route::get('/admin/business/index', [BusinessController::class, 'index'])->name('admin.business.index');
    Route::post('admin/business/suspend',[BusinessController::class,'suspend'])->name('business.suspend'); 
    Route::post('admin/business/suspend',[BusinessController::class,'suspend'])->name('business.suspend');  

    Route::get('admin/verified/{id}',[BusinessController::class,'verified'])->name('admin.verify');

    
     //admin managing town routes
    Route::resource('towns', TownController::class); 
    Route::resource('categories', CategoryController::class);

    Route::get('admin/system-charges',[SystemChargeController::class, 'index'])->name('system-charges.index');
    Route::get('admin/system-charges/create',[SystemChargeController::class, 'create'])->name('system-charges.create');
    
    Route::post('admin/system-charges',[SystemChargeController::class, 'store'])->name('system-charges.store');

    Route::get('admin/system-charges/edit/{id}',[SystemChargeController::class, 'create'])->name('system-charges.create');
    Route::post('admin/system-charges/update',[SystemChargeController::class, 'update'])->name('system-charges.update');

    Route::delete('admin/system-charges/{id}', [SystemChargeController::class, 'destroy'])->name('system-charges.destroy');

    Route::resource('system-charges', SystemChargeController::class);

});

Route::middleware(['auth', 'role:business'])->group(function () {
    // Business user routes
   
    // Onboarding 
    Route::get('/onboarding/stage1', [BusinessController::class, 'stage1'])->name('onboarding.stage1');
    Route::post('/onboarding/stage1', [BusinessController::class, 'stage1Store'])->name('onboarding.stage1.store'); 

    Route::get('/onboarding/stage2', [BusinessController::class, 'stage2'])->name('onboarding.stage2');
    Route::post('/onboarding/stage2', [BusinessController::class, 'stage2Store'])->name('onboarding.stage2.store');

    Route::get('/onboarding/stage3', [BusinessController::class, 'stage3'])->name('onboarding.stage3');
    Route::post('/onboarding/stage3', [BusinessController::class, 'stage3Store'])->name('onboarding.stage3.store');

    //updating profile pics

    Route::get('/updateprofpic', [BusinessController::class, 'updateprofilepic'])->name('profile.updateimage');   
    Route::post('/profile/update-image', [BusinessController::class, 'updateProfileImage'])->name('profile.update-image');
   
    Route::get('/admin/coupons/create', [CouponController::class, 'create'])->name('admin.coupons.create');
    Route::post('/admin/coupons/save', [CouponController::class, 'store'])->name('admin.coupons.store');
    Route::get('/admin/coupons/edit/{coupon}', [CouponController::class, 'edit'])->name('admin.coupons.edit');

    Route::get('/admin/coupons/rerun/{coupon}', [CouponController::class, 'rerun'])->name('admin.coupons.rerun');
    Route::post('/admin/coupons/savererun/{coupon}', [CouponController::class, 'savererun'])->name('admin.coupons.savererun');

    Route::get('/admin/coupons/addimage/{id}', [CouponController::class, 'addimage'])->name('admin.coupons.addimage');
    Route::post('/admin/coupons/saveimage/{id}', [CouponController::class, 'save_image'])->name('admin.coupons.saveimage');
    Route::put('/admin/coupons/update/{coupon}', [CouponController::class, 'update'])->name('admin.coupons.update');
    
    Route::get('myinterest',[BusinessController::class, 'myinterest'])->name('myinterest');
    Route::get('remove/myinterest/{id}',[BusinessController::class,'removeinterest'])->name('removeinterest');
    Route::get('add/myinterest',[BusinessController::class,'addminterest'])->name('addinterest');
    Route::post('save/myinterest',[BusinessController::class,'saveinterest']);

    Route::get('physicallocation',[BusinessController::class,'physicalLocation'])->name('physicalLocation');
    Route::post('savephysicallocation',[BusinessController::class,'savelocation'])->name('savelocation');

    Route::post('/admin/coupons/delete/{coupon}', [CouponController::class, 'destroy'])->name('admin.coupons.destroy');
 

});
Route::middleware(['auth', 'role:business|admin'])->group(function () {
    // business and admin-only routes

    Route::get('buss/underreview',[CouponController::class,'underreviewed'])->name('koupsunderreview');
    Route::get('buss/pendingcoupon',[CouponController::class,'pendingcoupons'])->name('admin.pendingcoupons');
    Route::get('buss/expiredcoupon',[CouponController::class,'bussexpiredcoup'])->name('bussexpiredcoup');    
    Route::get('/admin/coupons/suspended', [CouponController::class, 'suspendedCoupons'])->name('admin.coupons.suspended');
    Route::get('admin/coupons/matured-expired', [CouponController::class, 'maturedAndExpiredCoupons'])->name('admin.coupons.matured_expired');


    Route::get('/admin/coupons/index',[CouponController::class,'index'])->name('admin.coupons.index');

    Route::post('admin/coupons/{coupon}/suspend', [CouponController::class, 'suspend'])->name('admin.coupons.suspend');
    Route::post('admin/coupons/{coupon}/activate', [CouponController::class, 'activate'])->name('admin.coupons.activate');
    Route::post('/admin/coupons/{coupon}/approve', [CouponController::class, 'approve'])->name('admin.coupons.approve');

    // Show the lookup form
    Route::get('/order/lookup', [OrderLookupController::class, 'form'])->name('order.lookup');

    // Process the QR link or manual input
    //Route::get('/order/check', [OrderLookupController::class, 'check'])->name('order.check');

    Route::match(['GET','POST'], '/order/check', [OrderLookupController::class, 'check'])
    ->name('order.check');

    Route::patch('/orders/{order}/redeem', [OrderController::class, 'redeem'])->name('orders.redeem');    // or a business-only middleware if you have one



   
});


Route::middleware(['auth', 'role:customer|business'])->group(function () {
    // Customer-only routes

    Route::get('user/registration/stepone',[UserProfileController::class, 'steptwo'])->name('user.registration.steptwo');
    Route::post('user/registration/steptwo',[UserProfileController::class, 'savesteptwo'])->name('saveusersteptwo');
    Route::get('user/registration/stepthree',[UserProfileController::class, 'stepthree'])->name('user.registration.stepthree');
    Route::post('user/registration/stepthree',[UserProfileController::class, 'savestepthree'])->name('saveuserstepthree'); 


});

Route::middleware(['auth', 'role:admin|business|customer'])->group(function () {
    
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
     Route::get('/user-profiles', [UserProfileController::class, 'index'])->name('user-profiles.index');
     Route::patch('/user-profiles/{profile}/toggle-status', [UserProfileController::class, 'toggleStatus'])->name('user-profiles.toggle-status');
     Route::get('/profiles/{profile}', [UserProfileController::class, 'show'])->name('profiles.show');
    //  Route::post('/profiles/{profile}/blacklist', [UserProfileController::class, 'blacklist'])->name('profiles.blacklist');
    //  Route::post('/profiles/{profile}/unblacklist', [UserProfileController::class, 'unblacklist'])->name('profiles.unblacklist');

    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/orders/{order}/pdf', [OrderController::class, 'downloadPdf'])->name('orders.pdf');   
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

    

});

