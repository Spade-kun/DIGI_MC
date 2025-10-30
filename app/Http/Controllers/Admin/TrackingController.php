<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrackingDocument;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $query = TrackingDocument::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('tracking_no', 'LIKE', "%{$search}%");
        }

        $documents = $query->with('latestHistory')->orderBy('created_at', 'desc')->get();

        return view('admin.tracking.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'source_office' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'privacy' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Generate unique tracking number (format: XX-XXXX-XXX-XXX)
        $trackingNo = $this->generateTrackingNumber();

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tracking_documents', $fileName, 'public');
        }

        $document = TrackingDocument::create([
            'tracking_no' => $trackingNo,
            'name' => $request->name,
            'source_office' => $request->source_office,
            'document_type' => $request->document_type,
            'privacy' => $request->privacy,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'status' => 'Received',
            'uploaded_by' => Auth::guard('admin')->user()->email,
        ]);

        // Create initial history entry
        TrackingHistory::create([
            'tracking_document_id' => $document->id,
            'status' => 'Received',
            'updated_by' => Auth::guard('admin')->user()->email,
        ]);

        return redirect()->route('admin.tracking.index')->with('success', 'Document tracked successfully!');
    }

    public function show($id)
    {
        $document = TrackingDocument::with('histories')->findOrFail($id);
        return view('admin.tracking.show', compact('document'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Received,Drafting,For Review,Revision,Approved',
            'remarks' => 'nullable|string',
        ]);

        $document = TrackingDocument::findOrFail($id);
        $document->update([
            'status' => $request->status,
        ]);

        // Create history entry
        TrackingHistory::create([
            'tracking_document_id' => $document->id,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'updated_by' => Auth::guard('admin')->user()->email,
        ]);

        return redirect()->route('admin.tracking.show', $id)->with('success', 'Status updated successfully!');
    }

    public function search(Request $request)
    {
        $trackingNo = $request->input('tracking_no');
        
        $document = TrackingDocument::where('tracking_no', $trackingNo)->with('histories')->first();

        if (!$document) {
            return redirect()->route('admin.tracking.index')->with('error', 'No documents found matching the specified barcode. Please verify the barcode number and try again.');
        }

        return view('admin.tracking.show', compact('document'));
    }

    private function generateTrackingNumber()
    {
        // Generate format: XX-XXXX-XXX-XXX
        do {
            $part1 = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2));
            $part2 = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $part3 = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $part4 = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            
            $trackingNo = "{$part1}-{$part2}-{$part3}-{$part4}";
        } while (TrackingDocument::where('tracking_no', $trackingNo)->exists());

        return $trackingNo;
    }

    public function destroy($id)
    {
        $document = TrackingDocument::findOrFail($id);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.tracking.index')->with('success', 'Document deleted successfully!');
    }
}
