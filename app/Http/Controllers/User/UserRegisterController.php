<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Mail\UserRegistrationPending;

class UserRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('user.user-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'pending',
            ]);

            event(new Registered($user));

            // Send pending registration email
            Mail::to($user->email)->send(new UserRegistrationPending($user));

            // Show success modal on registration page
            return back()->with('registration_success', true)
                         ->with('user_name', $user->name);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('User registration failed: ' . $e->getMessage());
            
            return back()->withErrors([
                'email' => 'Registration failed. Please try again later or contact support.'
            ])->withInput();
        }
    }
}