<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SliderContent;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

class HomeController extends Controller
{
    public function index()
    {
        // $slider_contents = SliderContent::all();
        $newproducts = Product::where('status', 1)->with('variant')->orderBy('created_at', 'ASC')->limit(4)->get();
        $bestseller = Product::where('status', 1)->where('is_featured', 1)->with('variant')->orderBy('created_at', 'ASC')->limit(3)->get();
        $featured = Product::where('status', 1)->where('is_featured', 2)->with('variant')->orderBy('created_at', 'ASC')->limit(3)->get();
        $category = Category::with('subcategory')->orderBy('created_at', 'ASC')->limit(4)->get();
        return view('home', compact('category', 'newproducts', 'bestseller', 'featured'));
    }
}
