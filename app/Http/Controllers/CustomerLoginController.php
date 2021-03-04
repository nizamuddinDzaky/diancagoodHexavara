<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerLoginController extends Controller
{
    public function index()
    {
        $str = NULL;
        return view('dianca.login', compact('str'));
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

        // if customer->status 0 return not activated

        $credentials = $request->only('email', 'password');

        if(Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended(route('home'));
        } else {
            return redirect()->back()->with(['error' => 'Password salah.']);
        }
    }

    public function logout()
    {
        auth()->guard('customer')->logout();

        return redirect(route('home'));
    }
}
