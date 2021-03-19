<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\Customer;
use App\Models\Cart;
use Nexmo;

class CustomerRegisterController extends Controller
{
    public function index()
    {
        $str = NULL;
        return view('dianca.register', compact('str'));
    }

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'phone' => 'required|numeric',
        ]);

        $cust_email = Customer::where('email', $request->email)->first();
        
        if ($cust_email !== NULL) {
            return redirect()->back()->with(['error' => 'Akun sudah terdaftar, silakan Login']);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone,
            'activate_token' => Str::random(4)
        ]);

        // dd($customer);
        Cart::create([
            'customer_id' => $customer->id,
            'total_cost' => 0
        ]);

        $credentials = $request->only('email', 'password');

        if ($customer->status == false) {
            return redirect()->route('customer.sms_verification', ['id' => $customer->id]);
        } else if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended(route('home'));
        }
    }

    public function showVerificationForm($id)
    {
        $customer = Customer::where('id', $id)->first();

        $customer->update(['activate_token'=> Str::random(4)]);

        Nexmo::message()->send([
            'to' => '6281286930463',
            'from' => 'Vonage APIs',
            'text' => 'Verification code : ' . $customer->activate_token
        ]);
        
        return view('dianca.verify', compact('customer', 'id'));
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'digit_a' => 'required',
            'digit_b' => 'required',
            'digit_c' => 'required',
            'digit_d' => 'required',
            'customer_id' => 'required|exists:customers,id'
        ]);

        $customer = Customer::where('id', $request->customer_id)->first();

        $a = str_split($customer->activate_token, 1);

        if($request->digit_a == $a[0] &&
            $request->digit_b == $a[1] &&
            $request->digit_c == $a[2] &&
            $request->digit_d == $a[3]) {
                
                $customer->update(['status' => true]);
                
                $cart = Cart::create([
                    'customer_id' => $customer->id,
                    'total_cost'=> 0
                ]);
                
                Auth::login($customer);
                return redirect()->intended(route('home'));
            }

            return redirect()->back()->with(['error' => 'Kode verifikasi salah.']);
    }

}
