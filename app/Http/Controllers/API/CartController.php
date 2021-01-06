<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Cart as CartResource;
use Validator;
use App\Models\Cart;

class BrandController extends Controller
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
            'name' => 'required|string|max:50',
            'logo' => 'nullable|images|max:500|mimes:png,jpeg,jpg'
        ]);

        if($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error.']);
        }

        $brand = Brand::create($request->all());

        return response(['brand' => new BrandResource($brand), 'message' => 'Brand created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::find($id);
  
        if (is_null($brand)) {
            return $this->sendError('Brand not found.');
        }
        
        return response(['brand' => new BrandResource($brand), 'message' => 'Brand retrieved successfully.'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->all());

        return response(['brand' => new BrandResource($brand), 'message' => 'Brand Updated Successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response(['message' => 'Brand Deleted']);
    }
}
