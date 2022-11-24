<?php

namespace App\Http\Controllers\Frontend\LegalDocs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LegalDocsController extends Controller
{
    public function privacy(Request $request)
    {
        return view('frontend.legaldocs.privacy_home');
    }
}
