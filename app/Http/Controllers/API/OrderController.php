<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Http\Resources\Order as OrderResource;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return response(['orders' => OrderResource::collection($orders), 'message' => 'Orders retrieved successfully.'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer|exists:customers,id',
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required',
            'customer_email' => 'required|email',
            'customer_address' => 'required|string',
            'district_id' => 'required|exists:districts,id',
            'subtotal' => 'required|integer',
            'tracking_number' => 'required|string',
            'courier' => 'required'
        ]);

        $subtotal = 

        $order = Order::create([
            'invoice' => Str::random(4) . '-' . time(),
            'customer_id' => $customer_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'district_id' => $request->district_id,
            'subtotal' => $subtotal,
            'total_cost' => $subtotal + $shipping[2],
            'shipping_cost' => $shipping[2],
            'shipping' => $shipping[0] . '-' . $shipping[1],
            'free_access' => false
        ])
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
