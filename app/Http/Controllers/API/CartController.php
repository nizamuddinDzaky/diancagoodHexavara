<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Cart as CartResource;
use Validator;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();
        return response(['carts' => CartResource::collection($carts), 'message' => 'Carts retrieved successfully.'], 200);
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
            'customer_id' => 'required|integer',
            'total_cost' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error.']);
        }

        $cart = Cart::create($request->all());

        return response(['cart' => new CartResource($cart), 'message' => 'Cart created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = Cart::find($id);
  
        if (is_null($cart)) {
            return $this->sendError('Cart not found.');
        }
        
        return response(['cart' => new CartResource($cart), 'message' => 'Cart retrieved successfully.'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $cart->update($request->all());

        return response(['cart' => new CartResource($cart), 'message' => 'Cart Updated Successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response(['message' => 'Cart Deleted']);
    }
}
