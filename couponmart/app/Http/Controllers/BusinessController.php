<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Town;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;
use App\Services\PhotoService;

class BusinessController extends Controller
{
    
    public function stage1()
    {
        $town =Town::all();
        return view('onboarding.stage1',compact('town'));
    }

    public function stage1Store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'contact_name'  => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'town_id'       => 'required',
        ]);

        $business = Business::create([
            'user_id'       => Auth::id(),
            'business_name' => $request->business_name,
           // 'contact_name'  => $request->contact_name,
            'town_id' => $request->town_id,
            'phone_number'         => $request->phone,
            'status'        => 'pending',
        ]);

        // Assign step to a new customer
        $business->onboardingSteps()->create([
            'step_name' => 'Profile Completion',
            'step_order' => 1,
            'status' => 'pending'
        ]);

        // Mark step as completed
        $step = $business->onboardingSteps()->where('step_name', 'Profile Completion')->first();
        $step->update(['status' => 'completed']);

        return redirect()->route('onboarding.stage2');
    }

    public function stage2()
    {
        $business = Auth::user()->business;

        if (!$business) {
            abort(403, 'You do not have a business profile.');
        }

        // Check if this onboarding step already exists
        $existingStep = $business->onboardingSteps()
            ->where('step_name', 'Profile Completion')
            ->first();

        if (!$existingStep) {
            $business->onboardingSteps()->create([
                'step_name'  => 'Profile Completion',
                'step_order' => 3,
                'status'     => 'pending'
            ]);
        }

        $categories = Category::all();

        return view('onboarding.stagetwo', compact('categories'));
    }

    public function stage2Store(Request $request)
    {
        $request->validate([
            //'website'     => 'nullable|url|max:255',
            'bios'         => 'nullable|string|max:500',
            'categories'  => 'nullable|array',
            'categories.*'=> 'exists:categories,id'
        ]);

        try {
            $business = Auth::user()->business;

            if (!$business) {
                abort(403, 'You do not have a business to update.');
            }

            //$business->website = $request->website;
            $business->bios     = $request->bios;
            $business->save();

            // Sync categories (avoid duplicates)
            $business->categories()->sync($request->categories ?? []);

            
           return redirect()->route('onboarding.stage3'); 

        } catch (\Throwable $e) {
            // Log the error for debugging
            \Log::error('Onboarding Stage 2 Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace'   => $e->getTraceAsString()
            ]);

            // Return friendly message to user
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while saving your details. Please try again.');
        }
    }


     public function stage3()
    {
        $business = Auth::user()->business;

        if (!$business) {
            abort(403, 'You do not have a business profile.');
        }

        // Check if this onboarding step already exists
        $existingStep = $business->onboardingSteps()
            ->where('step_name', 'Profile Completion')
            ->where('step_order', 3)
            ->first();

        if (!$existingStep) {
            $business->onboardingSteps()->create([
                'step_name'  => 'Profile Completion',
                'step_order' => 3,
                'status'     => 'pending'
            ]);
        }

        
        return view('onboarding.stagethree');
    }    

    public function stage3Store(Request $request)
    {
        try {
            // Validate base64 image input
            $request->validate([
                'base64' => 'required|string',
            ]);

            // Get logged-in user's business
            $business = Auth::user()->business;
            if (!$business) {
                return response()->json(['error' => 'Business profile not found'], 404);
            }

            // Decode base64 and store image
            $photoService = new PhotoService();
            $outputDir = 'assets/business/';
            $imageName = $photoService->decodeBase64($request->base64, $outputDir);

            // Update business image
            $business->update([
                'image' => $imageName
            ]);

            // Mark onboarding step as completed if exists
            $step = $business->onboardingSteps()
                ->where('step_name', 'Profile Completion')
                ->first();

            if ($step) {
                $step->update(['status' => 'completed']);
            }

            return redirect()->route('dashboard')
                ->with('success', 'Onboarding complete. Awaiting approval.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Any other unexpected error
            \Log::error('Error saving business image: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An unexpected error occurred while saving the image. Please try again.');
        }
    }

    public function updateprofilepic(){
        $business = Auth::user()->business;

        if (!$business) {
            abort(403, 'You do not have a business profile.');
        }

        return view('onboarding.stagethree', [
            'updateMode' => true
        ]);


    }

    

    public function updateProfileImage(Request $request)
    {
        try {
            // Validate base64 input
            $request->validate([
                'base64' => 'required|string',
            ]);

            // Get logged-in user's business
            $business = Auth::user()->business;
            if (!$business) {
                return redirect()->back()->with('error', 'Business profile not found.');
            }

            // Decode and save image using existing PhotoService
            $photoService = new PhotoService();
            $outputDir = public_path('assets/business');
            $imageName = $photoService->decodeBase64($request->base64, $outputDir);

            if (!$imageName) {
                return redirect()->back()->with('error', 'Failed to process image. Please try again.');
            }

            // Delete old image if exists
            $oldImagePath = $outputDir . '/' . $business->image;
            if ($business->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Update business record
            $business->update(['image' => $imageName]);

            return redirect()->back()->with('success', 'Profile picture updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            \Log::error('Error updating profile image: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'An unexpected error occurred while updating the image.');
        }
    }


    public function physicalLocation(){

        $business=Auth::user()->business;

        return view('backend.business.physicallocation',compact('business'));

    }

    public function savelocation(Request $request)
    {
        try { 
            // Validate input
            $fields = $request->validate([
                'building' => 'required|string|max:255',
                'floor'    => 'required|string|max:255',
                'room'     => 'required|string|max:255',
            ]);

            // Get authenticated user's business
            $business = Auth::user()->business;

            if (!$business) {
                return back()->withErrors(['business' => 'Business record not found.']);
            }

            // Update location fields
            $business->building = $fields['building'];
            $business->floor    = $fields['floor'];
            $business->room     = $fields['room'];
            $business->save();

            return redirect('physicallocation')->with('success', 'Location updated successfully.');
        } catch (\Throwable $e) {
            // Log the error for debugging
            \Log::error('Error saving location: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace'   => $e->getTraceAsString()
            ]);

            // Show a generic error message
            return back()->withErrors(['error' => 'An unexpected error occurred while saving the location. Please try again.']);
        }
    }

    
    public function myinterest(){

        $business=Auth::user()->business;     
        $business_category=$business->categories;       
                        
        return view('backend.business.myinterest',compact('business_category')); 
    }

    public function removeinterest($id){
 
        $business = Auth::user()->business;     
        $business->categories()->detach($categoryId);
        
        return redirect()->route('myinterest')->with('success','Deletion was successful');

    } 

    public function addminterest()
    {
        $business = Auth::user()->business;     

        // Get IDs of categories the business already has
        $existingCategoryIds = $business->categories()->pluck('categories.id');       

        // Get categories not yet linked to this business
        $categories = Category::whereNotIn('id', $existingCategoryIds)->get();

        return view('backend.business.addminterest', compact('categories'));
    }

    public function saveinterest(Request $request)
    {
        $business_id = Auth::user()->business->id;
        
        if (!$business_id) {
            return redirect()->back()->with('error', 'No business found for this user.');
        }

        $validated = $request->validate([
        'categories' => 'array|max:4', // ensures it's an array with at most 4 items
        'categories.*' => 'exists:categories,id', // ensures each selected category exists
        ], [
            'categories.max' => 'You can select up to 4 categories only.',
        ]);

        $business = Auth::user()->business;

        // Sync the categories
        $business->categories()->sync($validated['categories'] ?? []);

        return redirect('myinterest')->with('success', 'Categories successfully added to your interests!');
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $businesses=business::all();

        return view('backend.admin.business.index',compact('businesses'));
    }
    public function suspend(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string|min:10', // Ensure reason is descriptive
            'business_id' => 'required|exists:businesses,id', // Ensure business_id exists in the businesses table
        ]);

        try {
            // Begin transaction
            DB::beginTransaction();

            // Add entry to BusinessBlacklisted
            $blacklist = new BusinessBlacklisted();
            $blacklist->business_id = $validated['business_id'];
            $blacklist->status = 'active';
            $blacklist->reasons = $validated['reason'];
            $blacklist->save();

            // Update the business status
            $business = Business::findOrFail($validated['business_id']);
            $business->status = 'blacklisted';
            $business->save();

            // Commit transaction
            DB::commit();

            return redirect()->route('admin.viewallbusiness')
                ->with('success', 'The suspension operation has been successful.');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            return redirect()->route('admin.viewallbusiness')
                ->with('error', 'An error occurred while suspending the business: ' . $e->getMessage());
        }
    }

    public function verified($id)
    {
        try {
             $business = Business::find($id);

            if (!$business) {
                return redirect()->route('admin.viewallbusiness')
                    ->with('error', 'Business not found.');
            }

            $business->update([
                'status' => 'active',
                'verified' => 'verified',
            ]);

            return redirect()->route('admin.business.index')
                ->with('success', 'The verification process was successful.');
        } catch (\Exception $e) {
            \Log::error('Business verification failed', [
                'business_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('admin.business.index')
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
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
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        //
    }
}
