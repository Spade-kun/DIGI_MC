<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserApproved;
use App\Mail\UserRejected;

class PendingRegistrationController extends Controller
{
    public function pending()
    {
        $users = User::where('status', 'pending')->latest()->get();
        return view('admin.user-list', [
            'users' => $users,
            'title' => 'Pending Users',
            'type' => 'pending'
        ]);
    }

    public function approved()
    {
        $users = User::where('status', 'approved')->latest()->get();
        return view('admin.user-list', [
            'users' => $users,
            'title' => 'Approved Users',
            'type' => 'approved'
        ]);
    }

    public function rejected()
    {
        $users = User::where('status', 'rejected')->latest()->get();
        return view('admin.user-list', [
            'users' => $users,
            'title' => 'Rejected Users',
            'type' => 'rejected'
        ]);
    }

    public function approve($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['status' => 'approved']);

            // Send approval email
            Mail::to($user->email)->send(new UserApproved($user));

            return redirect()->back()->with('success', "User '{$user->name}' has been approved successfully! Email notification sent to {$user->email}.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to approve user. Error: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['status' => 'rejected']);
            
            // Send rejection email
            Mail::to($user->email)->send(new UserRejected($user));
            
            return redirect()->back()->with('success', "User '{$user->name}' has been rejected. Email notification sent to {$user->email}.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reject user. Error: ' . $e->getMessage());
        }
    }
}