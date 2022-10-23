<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $customers = Customer::with('company')->get();

        return view('dashboard', ['customers' => $customers]);
    }
}
