<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\Customer;
use App\Models\Cart;
use Nexmo;

class CustomerRegisterController extends Controller
{
    public function index()
    {
        return view('dianca.register');
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

        $array = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone,
            'activate_token' => rand(0000, 9999)
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

        // dd($customer);

        $basic  = new \Vonage\Client\Credentials\Basic('979dab84', '8HHo1vBuxKedJlpR');
        $client = new \Vonage\Client(new \Vonage\Client\Credentials\Container($basic));

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($customer->phone_number, 'DiancaGoods', $customer->activate_token)
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }

        // $verification = Nexmo::message()->send([
        //     'to' => $customer->phone_number,
        //     'from' => 'DiancaGoods',
        //     'text' => $customer->activate_token
        // ]);

        // session(['nexmo_request_id' => $verification->getRequestId()]);

        // $response = $client->verify()->start($request);

        // $message = $gateway->message()->send([
        //     'to' => $customer-> 
        //     'from' => 'Vonage APIs',
        //     'text' => $customer->activate_token
        // ]);

        return view('dianca.verify', compact('customer'));
    }

    // public function verify(Request $request)
    // {
    //     $this->validate($request, [

    //     ])
        
    // }
}
