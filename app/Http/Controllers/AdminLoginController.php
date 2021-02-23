<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/administrator/orders';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function index()
    {
        if(Auth::guard('web')->check()) {
            return redirect(route('administrator.orders'));
        }

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
            return redirect()->intended(route('administrator.orders'));
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