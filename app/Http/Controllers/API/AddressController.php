<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Address as AddressResource;
use Validator;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::all();
        return response(['addresses' => AddressResource::collection($addresses), 'message' => 'Addresses retrieved successfully.'], 200);
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
            'customer_id' => 'required',
            'address_type' => 'required',
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'address' => 'required'
        ]);

        if($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error.']);
        }

        $address = Address::create($request->all());

        return response(['address' => new AddressResource($address), 'message' => 'Address created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::find($id);
  
        if (is_null($address)) {
            return $this->sendError('Address not found.');
        }
        
        return response(['address' => new AddressResource($address), 'message' => 'Address retrieved successfully.'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $address->update($request->all());

        return response(['address' => new AddressResource($address), 'message' => 'Address Updated Successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return response(['message' => 'Address Deleted']);
    }
}
