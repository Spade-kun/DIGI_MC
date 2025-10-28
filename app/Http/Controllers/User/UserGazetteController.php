<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gazette;
use Illuminate\Http\Request;

class UserGazetteController extends Controller
{
    /**
     * Display gazettes grouped by category
     */
    public function index()
    {
        // Get all gazettes except "Contract" category
        $gazettes = Gazette::where('category', '!=', 'Contract')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Group by category
        $gazettesByCategory = $gazettes->groupBy('category');
        
        return view('user.gazette.index', compact('gazettesByCategory'));
    }

    /**
     * Show specific gazette with embedded PDF
     */
    public function show(Gazette $gazette)
    {
        return view('user.gazette.show', compact('gazette'));
    }
}
