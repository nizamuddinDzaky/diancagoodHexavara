<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Address;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guard('customer')->check()) {
            $customer = Customer::with('address')->where('id', auth()->guard('customer')->user()->id)->first();
            $str = NULL;
            return view('dianca.profile', compact('customer', 'str'));
        }
    }

    public function listAdressCheckout()
    {
        if(Auth::guard('customer')->check()) {
            $address = Address::where('customer_id', auth()->guard('customer')->user()->id)->get();
            $html = View('dianca.list-address-checkout', compact('address'))->render();
            return $html;
        }
    }

    public function address()
    {
        if(auth()->guard('customer')->check()) {
            $address = Address::where('customer_id', auth()->guard('customer')->user()->id)->get();
            $provinces = Province::get();
            $str = NULL;
            return view('dianca.profile-alamat', compact('address', 'provinces', 'str'));
        }
    }

    public function rekening()
    {
        if(auth()->guard('customer')->check()) {
            $account = BankAccount::with('bank')->where('customer_id', auth()->guard('customer')->user()->id)->get();
            $banks = Bank::get();
            $sum = BankAccount::where('customer_id', auth()->guard('customer')->user()->id)->count();
            $str = NULL;
            return view('dianca.profile-rekening', compact('account', 'banks', 'sum', 'str'));
        }
    }

    public function editProfile(Request $request)
    {
        if(auth()->guard('customer')->check()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'birthday' => 'required',
                'gender' => 'required',
                'phone_number' => 'required'
            ]);

            $customer = Customer::find(auth()->guard('customer')->user()->id);
            // $filename = $product->image;
            // if($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            //     $file->storeAs('public/profiles', $filename);
            //     File::delete(storage_path('app/public/profiles') . $customer->image);
            // }

            $customer->update([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number
            ]);
    
            return redirect(route('profile'));
        }
    }

    public function addBank(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'image' => 'required|image|max:500|mimes:png,jpeg,jpg'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/storage/banks', $filename);

            $bank = Bank::create([
                'name' => $request->name,
                'image' => $filename
            ]);

            $bank_id = $bank->id;
        }
    }

    public function addBankAccount(Request $request)
    {
        if(auth()->guard('customer')->check()) {    
            $this->validate($request, [
                'bank_id' => 'required',
                'account_number' => 'required'
            ]);

            $bank_account = BankAccount::create([
                'customer_id' => auth()->guard('customer')->user()->id,
                'bank_id' => $request->bank_id,
                'account_number' => $request->account_number
            ]);

            return redirect(route('profile-rekening'));
        }
    }

    public function deleteBankAccount($id)
    {
        $account = BankAccount::find($id);
        $account->delete();
        return redirect(route('profile-rekening'));
    }

    public function addAddress(Request $request)
    {
        $countAddress = Address::where('customer_id', auth()->guard('customer')->user()->id)->count();

        $is_main = 0;
        
        if (isset($request->is_main)) {
            Address::where('customer_id', auth()->guard('customer')->user()->id)->update(['is_main'=>0]);
            $is_main = 1;
        }
        if ($countAddress == 0) {
            $is_main = 1;
        }

        $validator = Validator::make($request->all(), [
            'address_type' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_phone' => 'required|string',
            'district_id' => 'required|exists:districts,id',
            'postal_code' => 'required|string',
            'address' => 'required|string',
            'is_main' => 'boolean',
            'customer_id' => 'required|exists:customers,id'
        ]);

        // print_r($validator);die;

        $address = Address::create([
            'address_type' => $request->address_type,
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'district_id' => $request->district_id,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'is_main' => $is_main,
            'customer_id' => $request->customer_id
        ]);
        
        $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();
        $customer->update([
            'address' => 1
        ]);
        return redirect()->back();
    }

    public function updateAddress(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id',
            'address_type' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_phone' => 'required|string',
            'district_id' => 'required|exists:districts,id',
            'postal_code' => 'required|string',
            'address' => 'required|string',
            'is_main' => 'boolean'
        ]);

        $is_main = 0;
        
        if (isset($request->is_main)) {
            Address::where('customer_id', auth()->guard('customer')->user()->id)->update(['is_main'=>0]);
            $is_main = 1;
        }
        

        $address = Address::find($id);
        $address->update([
            'address_type' => $request->address_type,
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'postal_code' => $request->postal_code,
            'district_id' => $request->district_id,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'is_main' => $is_main,
        ]);

        return redirect()->back();
        // return redirect(route('profile-address'));
    }

    public function deleteAddress($id)
    {
        $address = Address::find($id);
        $address->delete();

        $sum = Address::where('customer_id', auth()->guard('customer')->user()->id)->count();
        if($sum == 0){
                $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();
                $customer->update([
                'address' => 0
            ]);
        }
        return redirect()->back();
    }

    public function getDetailAddreess()
    {
        $address = Address::find(request()->id);
        if ($address) {
            $response = [
                'status' => true,
                'data' => $address->toArray()
            ];
        }else{
            $response = [
                'status' => false,
                'data' => ''
            ];
        }
        return json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}