<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return view('user.user-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && $user->status === 'pending') {
            return back()->withErrors([
                'email' => 'Your account is pending approval. Please wait for admin approval.',
            ])->onlyInput('email');
        }

        if ($user && $user->status === 'rejected') {
            return back()->withErrors([
                'email' => 'Your registration has been rejected. Please contact admin for more information.',
            ])->onlyInput('email');
        }

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();
            if ($user->status !== 'approved') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is not approved yet.',
                ])->onlyInput('email');
            }
            
            $request->session()->regenerate();
            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/user/login');
    }
}