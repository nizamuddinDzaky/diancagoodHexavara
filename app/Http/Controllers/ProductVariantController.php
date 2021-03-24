<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;

class ProductVariantController extends Controller
{
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
        $variant = ProductVariant::find($id);
        $product = Product::orderBy('name', 'DESC')->get();
        // return view('products.variant.edit', compact('variant', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'nullable|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'name' => 'required|string|max:100',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:png,jpeg,jpg'
        ]);

        $variant = ProductVariant::find($request->variant_id);
        $filename = $variant->image;
        if ($request->hasFile('image')) {
            File::delete(storage_path('app/public/products/' . $variant->image));

            $file = $request->file('image');
            $filename = time() . $variant->id . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/variants/', $filename);

            $variant_image = ProductImage::where('product_variant_id', $variant->id)->first();
            $variant_image->filename = $filename;
            $variant_image->save();
        }

        try{
            $variant->update([
                'product_id' => $request->product_id,
                'name' => $request->name,
                'price' => $request->price,
                'weight' => $request->weight,
                'stock' => $request->stock,
                'image' => $filename
            ]);
        } catch (Exception $e) {
            return json_encode($e->getMessage());
        }
        
        return json_encode($variant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variant = ProductVariant::find($id);
        $variant_image = ProductImage::where('product_variant_id', $variant->id)->where('filename', $variant->image)->first();
        File::delete(storage_path('app/public/products/variants' . $variant->image));
        $variant->delete();
        $variant_image->delete();

        return true;
    }

    public function getDetail($id)
    {
        $variant = ProductVariant::find($id);
        return json_encode($variant);
    }
}
