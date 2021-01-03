<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $product = Product::where('status', 1)->with(['category', 'subcategory', 'variant'])->orderBy('created_at', 'DESC');
        // $category = Category::orderBy('name', 'DESC')->get();
        // $variant = ProductVariant::with(['product'])->get();
        // $product = $product->paginate(10);
        // return view('products.index', compact('product', 'category', 'variant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('name', 'DESC')->get();
        $subcategory = Subcategory::orderBy('name', 'DESC')->get();
        $brand = Brand::orderBy('name', 'DESC')->get();
        // return view('products.create', compact('category'));
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
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:100',
            'description' => 'required',
            'status' => 'required|boolean',
            'image' => 'required|image|max:500|mimes:png,jpeg,jpg'
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);

            $product = Product::create([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'slug' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'image' => $filename
            ]);

            $product_id = $product->id;

            $this->storeVariant($product_id, $request);

            // return redirect(route('product.index'))->with(['success' => 'Produk dan Varian Baru Ditambahkan!']);
        }
    }

    public function storeVariant($product_id, Request $request)
    {
        $this->validate($request, [
            'name_var' => 'required|string|max:100',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'minimum_stock' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'required|image|max:500|mimes:png,jpeg,jpg'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name_var) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/variants', $filename);

            $product = ProductVariant::create([
                'product_id' => $product_id,
                'name' => $request->name_var,
                'slug' => $request->name_var,
                'price' => $request->price,
                'weight' => $request->weight,
                'minimum_stock' => $request->minimum_stock,
                'stock' => $request->stock,
                'image' => $filename
            ]);
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
        $product = Product::where('id', $id)->with('variant', 'category', 'subcategory')->first();
        // return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::orderBy('name', 'DESC')->get();
        $subcategory = Subcategory::orderBy('name', 'DESC')->get();
        $brand = Brand::orderBy('name', 'DESC')->get();
        // return view('products.edit', compact('product', 'category', 'subcategory'));
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
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:100',
            'description' => 'required',
            'status' => 'required|boolean',
            'image' => 'nullable|image|max:500|mimes:png,jpeg,jpg'
        ]);

        $product = Product::find($id);
        $filename = $product->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);
            File::delete(storage_path('app/public/products/' . $product->image));
        }

        $product->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $filename
        ]);
        // return redirect(route('product.index'))->with(['success' => 'Data Produk Diperbaharui!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        File::delete(storage_path('app/public/products/' . $product->image));
        $product->delete();

        $product_variants = ProductVariant::where('product_id', $id)->get();

        foreach($product_variants as $v) {
            $v->delete();
        }
        // return redirect(route('product.index'))->with(['success' => 'Produk Sudah Dihapus!']);
    }
}
