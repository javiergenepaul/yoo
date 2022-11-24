<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.customer.customer_index');
    }
}
