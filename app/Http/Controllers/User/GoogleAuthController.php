<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user exists in database
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // User doesn't exist in our system
                return redirect()->route('user.login')
                    ->with('error', 'Your email is not registered. Please register first or contact admin.');
            }
            
            // Check user status
            if ($user->status === 'pending') {
                return redirect()->route('user.login')
                    ->with('error', 'Your account is pending approval. Please wait for admin approval.');
            }
            
            if ($user->status === 'rejected') {
                return redirect()->route('user.login')
                    ->with('error', 'Your registration has been rejected. Please contact admin for more information.');
            }
            
            if ($user->status !== 'approved') {
                return redirect()->route('user.login')
                    ->with('error', 'Your account is not approved yet. Please contact admin.');
            }
            
            // User is approved, log them in
            Auth::login($user);
            
            return redirect()->route('dashboard')
                ->with('success', 'Successfully logged in with Google!');
            
        } catch (\Exception $e) {
            return redirect()->route('user.login')
                ->with('error', 'Failed to authenticate with Google. Please try again.');
        }
    }
}
