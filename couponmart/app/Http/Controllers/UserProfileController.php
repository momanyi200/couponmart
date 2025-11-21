<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Auth;
use App\Models\Town;
use App\Models\Gender;
use App\Services\PhotoService;

class UserProfileController extends Controller
{

    //user registration
    public function steptwo(){

        $town=Town::all();
        $gender=Gender::all();
        return view ('backend.onboardinguser.steptwo',compact('town','gender'));
    }

     public function savesteptwo(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:user_profiles,phone_number',
            'town_id' => 'required|integer',
            'gender' => 'required|integer',
           
        ]);        

        // Create profile
        UserProfile::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'town_id' => $validated['town_id'],
            'gender' => $validated['gender'],
            'user_id' => Auth::user()->id,
        ]); 
       

        //return redirect()->route('home')->with('success', 'Registration successful!');
        return redirect()->route('user.registration.stepthree');
    }

    public function stepthree(){

        return view('backend.onboardinguser.stepthree');
    }

    public function savestepthree(Request $request)
    {
        // Validate input
        $request->validate([
            'base64' => 'required|string',
        ]);

        // Get authenticated user profile
        $profile = Auth::user()->profile;
        if (!$profile) {
            return redirect()->back()->withErrors(['profile' => 'Profile not found.']);
        }

        // Decode base64 and store image
        $photoService = new PhotoService();
        $outputDir = 'assets/users/';
        $imageName = $photoService->decodeBase64($request->base64, $outputDir);

        // Update profile image
        $profile->update([
            'image' => $imageName
        ]);

        return redirect('/')->with('success', 'Your registration was successful');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profiles = UserProfile::with(['user', 'town'])
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', "%{$request->search}%")
                    ->orWhere('last_name', 'like', "%{$request->search}%")
                    ->orWhere('phone_number', 'like', "%{$request->search}%")
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('email', 'like', "%{$request->search}%");
                    });
                });
            })
            ->when($request->town_id, fn($q) => $q->where('town_id', $request->town_id))
            ->when($request->gender, fn($q) => $q->where('gender', $request->gender))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->paginate(12)
            ->appends($request->query()); // keep filters in pagination

        $towns = Town::orderBy('town_name')->get();

        return view('backend.user_profiles.index', compact('profiles', 'towns'));
    }

    public function toggleStatus(Request $request, UserProfile $profile)
    {
        $isBlacklisting = $profile->status !== 'blacklisted';

        // Update status
        $profile->status = $isBlacklisting ? 'blacklisted' : 'active';
        $profile->save();

        // Log the action
        BlacklistLog::create([
            'user_profile_id' => $profile->id,
            'action' => $isBlacklisting ? 'blacklisted' : 'unblacklisted',
            'reason' => $request->reason,
            'performed_by' => auth()->id()
        ]);

        // Send email
        try {
            Mail::to($profile->user->email)->send(
                new \App\Mail\UserStatusChangedMail($profile, $isBlacklisting, $request->reason)
            );
        } catch (\Exception $e) {}

        return redirect()
            ->back()
            ->with('success', 'User status updated successfully.');
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
    
    public function show(UserProfile $profile)
    {
        $profile->load('blacklistLogs.admin', 'user', 'town');

        return view('backend.user_profiles.show', compact('profile'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserProfile $userProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}
