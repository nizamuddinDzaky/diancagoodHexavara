<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function showOrders()
    {
        if(Auth::guard('web')->check()) {
            $orders = Order::orderBy('created_at', 'DESC')->paginate(7);
            return view('admin.orders', compact('orders'));
        }
        return redirect(route('administrator.login'));
    }

    public function showOrder($id)
    {
        if(Auth::guard('web')->check()) {
            $order = Order::with('details.variant', 'payment', 'address.district.city.province')->where('id', $id)->first();
            return view('admin.order-show', compact('order'));
        }
        return redirect(route('administrator.login'));
    }

    public function updateTrackingInfo(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'order_id' => 'required|integer|exists:orders,id',
                'tracking_number' => 'required',
                'shipping_date' => 'required'
            ]);

            $order = Order::where('id', $request->order_id)->first();
            $order->update([
                'tracking_number' => $request->tracking_number,
                'shipping_date' => Carbon::createFromFormat('m/d/Y', $request->shipping_date),
                'status' => 2
            ]);
            
            return redirect()->back()->with(['success' => 'Data Pengiriman Disimpan!']);
        }
        return redirect(route('administrator.login'));
    }

    public function updatePaymentStatus(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'order_id' => 'required|integer|exists:orders,id',
            ]);

            $order = Order::where('id', $request->order_id)->first();
            $order->update(['status' => 1]);

            $payment = Payment::where('order_id', $order->id)->first();
            $payment->update(['status' => 2]);
            
            return redirect()->back()->with(['success' => 'Data Pembayaran Disimpan!']);
        }
        return redirect(route('administrator.login'));
    }

    public function showProducts()
    {
        if(Auth::guard('web')->check()) {
            $products = Product::with('variant', 'images')->orderBy('created_at', 'DESC')->paginate(6);
            return view('admin.products', compact('products'));
        }
        return redirect(route('administrator.login'));
    }

    public function fetchProducts($arg)
    {
        if(Auth::guard('web')->check()) {
            $products = Product::with('variant', 'images')->orderBy('created_at', 'DESC')->paginate(6);
            if($arg == 2) {
                $products = Product::with('variant', 'images')->orderBy('created_at', 'DESC')->limit(4);
            }
            
            $view = view('admin.products-list', compact('products'))->render();
            return response()->json(compact('view'));
        }
        return redirect(route('administrator.login'));
    }

    public function createProduct()
    {
        if(Auth::guard('web')->check()) {
            $categories = Category::orderBy('name', 'ASC')->get();
            $brands = Brand::orderBy('name', 'ASC')->get();
            return view('admin.products-add', compact('categories', 'brands'));
        }
        return redirect(route('administrator.login'));
    }

    public function addProduct(Request $request)
    {
        if(Auth::guard('web')->check()) {
            // dd($request);
            try {
                $this->validate($request, [
                    'name' => 'required|string',
                    'category_id' => 'required|integer|exists:categories,id',
                    'brand_id' => 'required|integer|exists:brands,id',
                    'price' => 'required',
                    'stock' => 'required',
                    'rate' => 'required',
                    'description' => 'string',
                    'images' => 'required',
                    'images.*' => 'mimes:jpg,jpeg,png'
                ]);

                $product = Product::create([
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'name' => $request->name,
                    'slug' => $request->name,
                    'description' => $request->description,
                    'rate' => $request->rate
                ]);

                $this->storeVariant($product->id, $request);

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $name = time() . $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
                        $image->storeAs('public/storage/products', $name);

                        $product_image = ProductImage::create([
                            'product_id' => $product->id,
                            'filename' => $name
                        ]);
                    }
                }

                return redirect(route('administrator.products'))->with(['success' => 'Produk dan Varian Baru Ditambahkan!']);
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }

    public function editProduct($id)
    {
        if(Auth::guard('web')->check()) {
            $product = Product::with('images', 'brand', 'subcategory.category')->where('id', $id)->first();
            $categories = Category::orderBy('name', 'ASC')->get();
            $subcategories = Subcategory::orderBy('name', 'ASC')->get();
            $brands = Brand::orderBy('name', 'ASC')->get();
            $product_variants = ProductVariant::where('product_id', $product->id)->get();
            
            // dd($product);
            return view('admin.products-edit', compact('product', 'categories', 'subcategories', 'brands', 'product_variants'));
        }
        return redirect(route('administrator.login'));
    }

    public function storeVariant($product_id, Request $request)
    {
        if (Auth::guard('web')->check()) {
            $this->validate($request, [
                'name' => 'required|string',
                'price' => 'required|integer',
                'weight' => 'required|integer',
                'stock' => 'required|integer',
            ]);

            $product = ProductVariant::create([
                'product_id' => $product_id,
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);
        }
    }

    public function storeCategory(Request $request)
    {
        if (Auth::guard('web')->check()) {
            try {
                $this->validate($request, [
                    'name' => 'required|string',
                    'image_category' => 'required|image|mimes:png,jpeg,jpg'
                ]);
    
                if($request->hasFile('image_category')) {
                    $image = $request->file('image_category');
                    $name = time() . $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/storage/categories', $name);
        
                    $category = Category::create([
                        'name' => $request->name,
                        'slug' => $request->name,
                        'image' => $name
                    ]);
                }
                return redirect()->back()->with(['success' => "Kategori Ditambahkan!"]);
            } catch (\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }   
    }

    public function storeSubcategory(Request $request)
    {
        if (Auth::guard('web')->check()) {
            try {
                $this->validate($request, [
                    'popup_category_id' => 'required|integer|exists:categories,id',
                    'name' => 'required|string'
                ]);
    
                $subcategory = Subcategory::create([
                    'category_id' => $request->popup_category_id,
                    'name' => $request->name,
                    'slug' => $request->name
                ]);
                return redirect()->back()->with(['success' => "Subkategori Ditambahkan!"]);
            } catch (\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }  
    }

    public function storeBrand(Request $request)
    {
        if (Auth::guard('web')->check()) {
            try {
                $this->validate($request, [
                    'name' => 'required|string'
                ]);
    
                $subcategory = Brand::create([
                    'name' => $request->name,
                    'slug' => $request->name
                ]);
                return redirect()->back()->with(['success' => "Brand Ditambahkan!"]);
            } catch (\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }  
    }

    public function getSubcategories()
    {
        $subcategories = Subcategory::where('category_id', request()->category_id)->get();
        return response()->json(['status' => 'success', 'data' => $subcategories]);
    }

    public function showTracking($status)
    {
        if(Auth::guard('web')->check()) {
            $orders = Order::where('status', $status)->orderBy('created_at', 'DESC')->paginate(7);
            return view('admin.tracking', compact('orders'));
        }
        return redirect(route('administrator.login'));
    }

    public function changeOrderStatus($id, $status)
    {
        if(Auth::guard('web')->check()) {
            $order = Order::where('id', $id)->first();
            $order->status = $status;
            $order->save();
            return redirect()->back()->with(['success' => 'Status Order Diubah!']);
        }
        return redirect(route('administrator.login'));
    }
}