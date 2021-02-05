<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        // return view('products.variant.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:100',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'minimum_stock' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'required|image|max:500|mimes:png,jpeg,jpg'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/variants', $filename);

            $product = ProductVariant::create([
                'product_id' => $request->product_id,
                'name' => $request->name,
                'slug' => $request->name,
                'price' => $request->price,
                'weight' => $request->weight,
                'minimum_stock' => $request->minimum_stock,
                'stock' => $request->stock,
                'image' => $filename
            ]);
            // return redirect(route('product.index'))->with(['success' => 'Varian Produk Baru Ditambahkan!']);
        }
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:100',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'minimum_stock' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:500|mimes:png,jpeg,jpg'
        ]);

        $product = ProductVariant::find($id);
        $filename = $product->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/variants', $filename);
            File::delete(storage_path('app/public/variants/' . $product->image));
        }

        try{
            $product->update([
                'product_id' => $request->product_id,
                'name' => $request->name,
                'price' => $request->price,
                'weight' => $request->weight,
                'minimum_stock' => $request->minimum_stock,
                'stock' => $request->stock,
                'image' => $filename
            ]);
        } catch (Exception $e) {
            // return redirect(route('product.index'))->with(['error' => $e->getMessage()]);
        }
        
        // return redirect(route('product.index'))->with(['success' => 'Data Varian Produk Diperbaharui!']);
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
        File::delete(storage_path('app/public/products/variants' . $variant->image));
        $variant->delete();
        // return redirect(route('product.index'))->with(['success' => 'Varian Produk Sudah Dihapus']);
    }
}
