<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrackingDocument;
use Illuminate\Http\Request;

class UserTrackingController extends Controller
{
    /**
     * Display tracking index page
     */
    public function index(Request $request)
    {
        $query = TrackingDocument::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('tracking_no', 'LIKE', "%{$search}%");
        }

        $documents = $query->with('latestHistory')->orderBy('created_at', 'desc')->get();

        return view('user.tracking.index', compact('documents'));
    }

    /**
     * Display tracking details by tracking number
     */
    public function show($trackingNo)
    {
        $document = TrackingDocument::where('tracking_no', $trackingNo)
            ->with('histories')
            ->first();

        if (!$document) {
            return redirect()->route('user.tracking.index')
                ->with('error', 'Tracking number not found. Please check and try again.');
        }

        return view('user.tracking.show', compact('document'));
    }

    /**
     * Search for tracking document
     */
    public function search(Request $request)
    {
        $request->validate([
            'tracking_no' => 'required|string',
        ]);

        $trackingNo = $request->input('tracking_no');
        
        $document = TrackingDocument::where('tracking_no', $trackingNo)
            ->with('histories')
            ->first();

        if (!$document) {
            return redirect()->route('user.tracking.index')
                ->with('error', 'No documents found matching the tracking number. Please verify and try again.');
        }

        return redirect()->route('user.tracking.show', $trackingNo);
    }
}
