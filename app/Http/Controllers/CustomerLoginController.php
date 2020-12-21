<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerLoginController extends Controller
{
    public function index()
    {
        return view('dianca.login');
    }

    public function showVerificationForm()
    {
        return view('dianca.verify');
    }
}
