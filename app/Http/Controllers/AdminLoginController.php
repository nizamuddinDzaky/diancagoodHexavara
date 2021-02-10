<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return redirect()->back()->with(['error' => 'Email salah.']);
        }

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            return redirect()->intended(route('administrator.dashboard'));
        } else {
            return redirect()->back()->with(['error' => 'Password salah.']);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('administrator.login'));
    }
}
