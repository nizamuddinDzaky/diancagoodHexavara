<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('created_at', 'DESC')->paginate(10);
        // return view('categories.index', compact('category'));
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
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories',
            'image' => 'required|image|max:500|mimes:png,jpeg,jpg'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/categories', $filename);

            $category = Category::create([
                'name' => $request->name,
                'slug' => $request->name,
                'image' => $filename
            ]);

            $category_id = $category->id;

            // $this->storeVariant($product_id, $request);

            // return redirect(route('product.index'))->with(['success' => 'Produk dan Varian Baru Ditambahkan!']);
        }

        // $request->request->add(['slug' => $request->name]);
        // Category::create($request->except('_token'));
        // return redirect(route('category.index'))->with(['success' => 'Kategori Baru Ditambahkan!']);
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
        $category = Category::find($id);
        // return view('categories.edit', compact('category'));
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
            'image' => 'nullable|image|max:500|mimes:png,jpeg,jpg',
            'name' => 'required|string|max:50|unique:categories,name,' . $id
        ]);

        $category = Category::find($id);
        $filename = $category->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/categories', $filename);
            File::delete(storage_path('app/public/categories/' . $category->image));
        }

        $category->update([
            'name' => $request->name,
            'image' => $filename
        ]);
        // return redirect(route('category.index'))->with(['success' => 'Data Kategori Diperbaharui!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        File::delete(storage_path('app/public/categories/' . $category->image));
        $category->delete();

        $subcategory = Subcategory::where('category_id', $id)->get();

        foreach($subcategory as $v) {
            $v->delete();
        }
        // return redirect(route('category.index'))->with(['success' => 'Kategori Sudah Dihapus!']);
    }
}
