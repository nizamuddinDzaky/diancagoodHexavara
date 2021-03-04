<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SliderContent;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        $newproducts = Product::where('status', 1)->with('variant', 'images')->orderBy('created_at', 'ASC')->limit(4)->get();
        $bestseller = Product::where('status', 1)->where('is_featured', 1)->with('variant', 'images')->orderBy('created_at', 'ASC')->limit(3)->get();
        $featured = Product::where('status', 1)->where('is_featured', 2)->with('variant', 'images')->orderBy('created_at', 'ASC')->limit(3)->get();
        $category = Category::with('subcategory')->orderBy('created_at', 'ASC')->limit(4)->get();
        $str = NULL;
        return view('home', compact('category', 'newproducts', 'bestseller', 'featured', 'str'));
    }

    public function aboutUs()
    {
        return view('dianca.about-us');
    }

    public function termCondition()
    {
        return view('dianca.term-condition');
    }

    public function show(Request $request)
    {
        $product = new Product();
        // $product = Product::with('variant', 'images')->orderBy('created_at', 'ASC')->get();
        $category = Category::with('subcategory')->get();
        $brand = Brand::with('product')->get();

        $str = request()->q;
        $searchVal = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);
        // $str1 = request()->cat;

        // if($request->input('q')){
        //     $product = $product->where('name', 'like', "%{$request->q}%");
        // }

        if (request()->q != '') {
            $product = $product->where(function($q) use ($searchVal) {
                foreach ($searchVal as $val){
                    $q->orWhere('name', 'like', "%{$val}%");
                }
            });
        }

        // if (request()->cat != '') {
        //     $product = $product->where(function($cat) use ($str1) {
        //         foreach ($str1 as $var){
        //             $cat->orWhere('category_id', $var);
        //         }
        //     });
        // }
        
        $product = $product->with('variant', 'images', 'reviews')->orderBy('created_at', 'ASC')->get();
        return view('dianca.search', compact('product', 'category', 'brand', 'str'));
    }

    public function categoryFilter($id)
    {
        $product = Category::where('id', $id)->first()->product()->orderBy('created_at', 'DESC')->get();
        $category = Category::with('subcategory')->get();
        $brand = Brand::with('product')->get();
        $str = NULL;
        return view('dianca.search', compact('product', 'category', 'brand', 'str'));
    }

    public function categoryFilters($id, $name)
    {
        $product = new Product();
        // $product = Category::where('id', $id)->first()->product()->orderBy('created_at', 'DESC')->get();
        $category = Category::with('subcategory')->get();
        $brand = Brand::with('product')->get();

        $str = $name;
        $searchVal = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);

        if ($str != '') {
            $product = $product->where('category_id', $id)->where(function($q) use ($searchVal) {
                foreach ($searchVal as $val){
                    $q->orWhere('name', 'like', "%{$val}%");
                }
            });
        }

        $product = $product->with('variant', 'images', 'reviews')->orderBy('created_at', 'ASC')->get();
        return view('dianca.search', compact('product', 'category', 'brand', 'str'));
    }

    public function brandFilter($id, $name)
    {
        $product = new Product();
        // $product = Brand::where('slug', $slug)->first()->product()->orderBy('created_at', 'DESC')->get();
        $category = Category::with('subcategory')->get();
        $brand = Brand::with('product')->get();

        $str = $name;
        $searchVal = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);

        if ($str != '') {
            $product = $product->where('brand_id', $id)->where(function($q) use ($searchVal) {
                foreach ($searchVal as $val){
                    $q->orWhere('name', 'like', "%{$val}%");
                }
            });
        }

        $product = $product->with('variant', 'images', 'reviews')->orderBy('created_at', 'ASC')->get();
        return view('dianca.search', compact('product', 'category', 'brand', 'str'));
    }
}
