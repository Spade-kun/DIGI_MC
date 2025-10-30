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
        $pendingUsers = User::where('status', 'pending')->latest()->get();
        $approvedUsers = User::where('status', 'approved')->latest()->get();
        $rejectedUsers = User::where('status', 'rejected')->latest()->get();
        
        return view('admin.users-management', [
            'pendingUsers' => $pendingUsers,
            'approvedUsers' => $approvedUsers,
            'rejectedUsers' => $rejectedUsers
        ]);
    }

    public function approved()
    {
        $pendingUsers = User::where('status', 'pending')->latest()->get();
        $approvedUsers = User::where('status', 'approved')->latest()->get();
        $rejectedUsers = User::where('status', 'rejected')->latest()->get();
        
        return view('admin.users-management', [
            'pendingUsers' => $pendingUsers,
            'approvedUsers' => $approvedUsers,
            'rejectedUsers' => $rejectedUsers
        ]);
    }

    public function rejected()
    {
        $pendingUsers = User::where('status', 'pending')->latest()->get();
        $approvedUsers = User::where('status', 'approved')->latest()->get();
        $rejectedUsers = User::where('status', 'rejected')->latest()->get();
        
        return view('admin.users-management', [
            'pendingUsers' => $pendingUsers,
            'approvedUsers' => $approvedUsers,
            'rejectedUsers' => $rejectedUsers
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