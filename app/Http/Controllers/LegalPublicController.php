<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalPublicController extends Controller
{
    public function index()
    {
        return view('legal.public.index');
    }
}
