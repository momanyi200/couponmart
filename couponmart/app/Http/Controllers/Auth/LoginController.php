<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt login
        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->remember
        )) {
            $request->session()->regenerate();

            // Redirect based on user type
            if (Auth::user()->is_business_owner) {
                return redirect()->route('business.dashboard')
                    ->with('success', 'Welcome back to your business dashboard!');
            }

            return redirect()->route('home')->with('success', 'Logged in successfully.');
        }

        // Failed login
        return back()->with('error', 'Invalid email or password.')
                     ->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }
}
