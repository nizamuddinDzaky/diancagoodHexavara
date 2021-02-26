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
        
        return view('home', compact('category', 'newproducts', 'bestseller', 'featured'));
    }

    public function aboutUs()
    {
        return view('dianca.about-us');
    }

    public function termCondition()
    {
        return view('dianca.term-condition');
    }

    public function show()
    {
        $product = Product::with('variant', 'images')->get();
        $category = Category::with('subcategory')->get();
        $brand = Brand::with('product')->get();

        $str = request()->q;
        $searchVal = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);

        if (request()->q != '') {
            $product = $product->where(function($q) use ($searchVal) {
                foreach ($searchVal as $val){
                    $q->orWhere('name', 'like', "%{$val}%");
                }
            });
        }
        
        $product = $product->get();
        return view('dianca.search', compact('product', 'category', 'brand'));
    }

    public function categoryFilter($id)
    {
        $products = Product::with('images', 'variant')->where('category_id', $id)->orderBy('created_at', 'DESC')->get();
        $categories = Category::with('subcategory')->get();
        $brands = Brand::get();
        return view('dianca.product-list', compact('products', 'categories', 'brands'));
    }

    public function brandFilter($id)
    {
        $products = Product::with('images', 'variant')->where('brand_id', $id)->orderBy('created_at', 'DESC')->get();
        $categories = Category::with('subcategory')->get();
        $brands = Brand::get();
        return view('dianca.search', compact('product', 'categories', 'brands'));
    }
}
