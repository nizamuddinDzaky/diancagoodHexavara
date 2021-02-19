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
            return view('dianca.profile', compact('customer'));
        }
    }

    public function address()
    {
        if(auth()->guard('customer')->check()) {
            return view('dianca.profile-alamat');
        }
    }

    public function rekening()
    {
        if(auth()->guard('customer')->check()) {
            $account = BankAccount::with('bank')->where('customer_id', auth()->guard('customer')->user()->id)->get();
            $banks = Bank::get();
            return view('dianca.profile-rekening', compact('account', 'banks'));
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
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/banks', $filename);

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