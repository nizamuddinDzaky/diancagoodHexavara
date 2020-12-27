<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

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

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|string'
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if(!$customer) {
            return redirect()->back()->with(['error' => 'Email salah.']);
        }

        if(Hash::check($request->password, $customer->password)) {
            return redirect()->intended(route('home'));
        } else {
            return redirect()->back()->with(['error' => 'Password salah.']);
        }
    }
}
