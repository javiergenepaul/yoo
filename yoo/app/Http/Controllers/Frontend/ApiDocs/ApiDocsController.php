<?php

namespace App\Http\Controllers\Frontend\ApiDocs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiDocsController extends Controller
{
    public function apiDocs(Request $request)
    {
        return view('frontend.apidocs.api_docs_home');
    }
}
