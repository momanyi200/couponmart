<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    //
     use HasRoles; 
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            //'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:8|confirmed',
            'account_type' => ['required'],
        ]);

        $dev_role = Role::where('name', $request->account_type)->first();

        $user = User::create([
            //'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // will be hashed automatically if mutator exists
        ]);

        $user->assignRole($dev_role);        

        // Store user onboarding info in session
       
        Auth::login($user);

        // If business account, start onboarding at Stage 1
        if ($request->account_type === 'business') {
            return redirect()->route('onboarding.stage1')
                ->with('success', 'Welcome! Let’s set up your business profile.');
        }


        // Otherwise, go to normal dashboard
        return redirect()->route('user.registration.steptwo')
            ->with('success', 'Account created successfully.');
    }

}
