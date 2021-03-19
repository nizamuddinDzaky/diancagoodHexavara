<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use Carbon\Carbon;
use PDF;
use Excel;
use File;
use stdClass;
use App\Exports\PaymentReport;
use App\Exports\SalesReport;
use App\Exports\TransactionReport;
use App\Exports\ProductReport;

class DashboardController extends Controller
{
    public function showOrders()
    {
        if(Auth::guard('web')->check()) {
            $orders = Order::with('address')->orderBy('created_at', 'DESC')->paginate(7);
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

    // produk
    
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
            try {
                $this->validate($request, [
                    'name' => 'required|string',
                    'category_id' => 'required|integer|exists:categories,id',
                    'brand_id' => 'required|integer|exists:brands,id',
                    'price' => 'required',
                    'stock' => 'required',
                    'rate' => 'required',
                    'description' => 'string',
                    'image_product' => 'required',
                    'image_product.*' => 'mimes:jpg,jpeg,png'
                ]);

                $product = Product::create([
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'name' => $request->name,
                    'slug' => $request->name,
                    'description' => $request->description,
                    'rate' => $request->rate
                ]);

                if ($request->hasFile('image_product')) {
                    foreach ($request->file('image_product') as $image) {
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
            
            return view('admin.products-edit', compact('product', 'categories', 'subcategories', 'brands', 'product_variants'));
        }
        return redirect(route('administrator.login'));
    }

    public function updateProduct(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'product_id' => 'required|integer|exists:products,id',
                'name' => 'required|string',
                'category_id' => 'required|integer|exists:categories,id',
                'subcategory_id' => 'required|integer|exists:subcategories,id',
                'brand_id' => 'required|integer|exists:brands,id',
                'price' => 'required',
                'stock' => 'required',
                'rate' => 'required',
                'description' => 'string',
            ]);

            try {
                $product = Product::where('id', $request->product_id)->first();
                $product->update([
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'brand_id' => $request->brand_id,
                    'name' => $request->name,
                    'slug' => $request->name,
                    'description' => $request->description,
                    'rate' => $request->rate
                ]);

                $product->save();

                return redirect(route('administrator.products'))->with(['success' => 'Produk Berhasil Diperbarui!']);
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }

    public function storeVariant(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $this->validate($request, [
                'name' => 'required|string',
                'price' => 'required|integer',
                'weight' => 'required|integer',
                'stock' => 'required|integer',
                'image_variant' => 'mimes:jpg,jpeg,png',
            ]);

            $product_variant = ProductVariant::create([
                'name' => $request->name,
                'price' => $request->price,
                'weight' => $request->weight,
                'stock' => $request->stock,
            ]);

            if ($request->hasFile('images_variant')) {
                foreach ($request->file('image_variant') as $image) {
                    $name = time() . $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/storage/variants', $name);

                    $product_image = ProductImage::create([
                        'product_id' => $product->id,
                        'product_variant_id' => $product_variant->id,
                        'filename' => $name
                    ]);
                    
                    $product_variant->image = $product_image->filename;
                    $product_variant->save();
                }
            }

            return json_encode($product_variant);
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

    // Report

    public function allReport()
    {
        if(Auth::guard('web')->check()) {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

            if (request()->from_date != '' && request()->to_date != '') {
                $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
                $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
            }

            $total_order = Order::whereBetween('created_at', [$start, $end])->count();

            $monthly_income = Order::where('status', 1)->orWhere('status', 2)->orWhere('status', 3)->orWhere('status', 4)->orWhere('status', 5)->whereBetween('created_at', [$start, $end])->sum('subtotal');
            
            $finished = Order::whereBetween('updated_at', [$start, $end])->get();
            $monthly_sold = 0;
            foreach ($finished as $f) {
                $monthly_sold += OrderDetail::where('order_id', $f->id)->sum('qty');
            }

            $sold = ProductVariant::with('product')->whereBetween('created_at', [$start, $end])->whereRaw('stock <= 0')->count();
            // $sold = Product::with('variant')->whereRaw('product->variant->stock <= 0')->count();

            $orders = Order::with('payment')->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'ASC')->get();
            return view('report.all-report', compact('orders', 'monthly_income', 'monthly_sold', 'total_order', 'sold', 'start', 'end'));
        }
        return redirect(route('administrator.login'));
    }

    public function productReport()
    {
        if(Auth::guard('web')->check()) {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

            if (request()->from_date != '' && request()->to_date != '') {
                $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
                $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
            }

            $products = Product::with('variant', 'images')->whereBetween('updated_at', [$start, $end])->orderBy('created_at', 'ASC')->get();
            
            foreach($products as $p){
                foreach($p->variant as $pv){
                    $pv['sold'] = OrderDetail::where('product_variant_id', $pv['id'])->whereBetween('created_at', [$start, $end])->sum('qty');
                    $pv['total'] = OrderDetail::where('product_variant_id', $pv['id'])->whereBetween('created_at', [$start, $end])->sum('price');
                }
            }
            
            return view('report.product-report', compact('products', 'start', 'end'));
        }
        return redirect(route('administrator.login'));
    }

    public function productSoldReport()
    {
        if(Auth::guard('web')->check()) {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

            if (request()->from_date != '' && request()->to_date != '') {
                $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
                $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
            }

            $products = Product::with('variant', 'images')->whereBetween('updated_at', [$start, $end])->orderBy('created_at', 'ASC')->get();
            
            foreach($products as $p){
                foreach($p->variant as $pv){
                    $pv['sold'] = OrderDetail::where('product_variant_id', $pv['id'])->whereBetween('created_at', [$start, $end])->sum('qty');
                    $pv['total'] = OrderDetail::where('product_variant_id', $pv['id'])->whereBetween('created_at', [$start, $end])->sum('price');
                }
            }
            
            return view('report.product-report', compact('products', 'start', 'end'));
        }
        return redirect(route('administrator.login'));
    }

    public function productSoldoutReport()
    {
        if(Auth::guard('web')->check()) {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

            if (request()->from_date != '' && request()->to_date != '') {
                $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
                $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
            }

            // $products = Product::with('product', 'images')->get();
            // foreach ($products as $f) {
            //     $soldout = ProductVariant::with('product')->where('product_id', $f->id)->whereRaw('stock <= 0')->get();
            // }
            // $products = ProductVariant::with('product')->whereRaw('stock <= 0')->get();
            $products = Product::with('variant', 'images')->whereBetween('updated_at', [$start, $end])->orderBy('created_at', 'ASC')->get();
            return view('report.product-soldout-report', compact('products'));
        }
        return redirect(route('administrator.login'));
    }

    public function paymentReport()
    {
        if(Auth::guard('web')->check()) {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

            if (request()->from_date != '' && request()->to_date != '') {
                $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
                $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
            }
            $orders = Order::with('payment')->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'ASC')->get();

            $total_payment = 0;
            $count_payment = 0;
            foreach ($orders as $f) {
                $total_payment += Payment::where('order_id', $f->id)->sum('amount');
                $count_payment++;
            }

            return view('report.payment-report', compact('orders', 'total_payment', 'count_payment', 'start', 'end'));
        }
        return redirect(route('administrator.login'));
    }

    public function salesReport()
    {
        if(Auth::guard('web')->check()) {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

            if (request()->from_date != '' && request()->to_date != '') {
                $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
                $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
            }
            $orders = Order::with('details')->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'ASC')->get();

            return view('report.sales-report', compact('orders', 'start', 'end'));
        }
        return redirect(route('administrator.login'));
    }

    // Export as PDF

    public function paymentReportPDF()
    {
    	if(Auth::guard('web')->check()) {
            $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';

            $orders = Order::with('payment')->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'ASC')->get();

            $total_payment = 0;
            $count_payment = 0;
            foreach ($orders as $f) {
                $total_payment += Payment::where('order_id', $f->id)->sum('amount');
                $count_payment++;
            }
            
            view()->share('orders', $orders);
            $pdf = PDF::loadView('report.payment-report-print', ['orders'=>$orders, 'start'=>$start, 'end'=>$end, 'count_payment'=>$count_payment, 'total_payment'=>$total_payment]);
            return $pdf->download('laporan-pembayaran-diancagoods.pdf');
        }
        return redirect(route('administrator.login'));
    }

    public function allReportPDF()
    {
    	if(Auth::guard('web')->check()) {
            $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';

            $orders = Order::with('payment')->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'ASC')->get();

            $total_order = Order::whereBetween('created_at', [$start, $end])->count();

            $monthly_income = Order::whereBetween('created_at', [$start, $end])->sum('subtotal');
            
            view()->share('orders', $orders);
            $pdf = PDF::loadView('report.all-report-print', ['orders'=>$orders, 'start'=>$start, 'end'=>$end, 'total_order'=>$total_order, 'monthly_income'=>$monthly_income]);
            return $pdf->download('laporan-transaksi-diancagoods.pdf');
        }
        return redirect(route('administrator.login'));
    }

    public function salesReportPDF()
    {
    	if(Auth::guard('web')->check()) {
            $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';

            $orders = Order::with('details')->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'ASC')->get();
            
            $total_sales = 0;
            $monthly_income = 0;
            foreach ($orders as $f) {
                $monthly_income += OrderDetail::where('order_id', $f->id)->whereBetween('created_at', [$start, $end])->sum('price');
                $total_sales += OrderDetail::where('order_id', $f->id)->sum('qty');
            }
            
            view()->share('orders', $orders);
            $pdf = PDF::loadView('report.sales-report-print', ['orders'=>$orders, 'start'=>$start, 'end'=>$end, 'total_sales'=>$total_sales, 'monthly_income'=>$monthly_income]);
            return $pdf->download('laporan-penjualan-diancagoods.pdf');
        }
        return redirect(route('administrator.login'));
    }

    public function productReportPDF()
    {
    	if(Auth::guard('web')->check()) {
            $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';

            $products = Product::with('variant', 'images')->whereBetween('updated_at', [$start, $end])->orderBy('created_at', 'ASC')->get();
            
            foreach($products as $p){
                foreach($p->variant as $pv){
                    $pv['sold'] = OrderDetail::where('product_variant_id', $pv['id'])->whereBetween('created_at', [$start, $end])->sum('qty');
                    $pv['total'] = OrderDetail::where('product_variant_id', $pv['id'])->whereBetween('created_at', [$start, $end])->sum('price');
                }
            }

            $total_count = 0;
            $total_sold = 0;
            $total_count = OrderDetail::whereBetween('created_at', [$start, $end])->sum('qty');
            $total_sold = OrderDetail::whereBetween('created_at', [$start, $end])->sum('price');

            // $total_count = $products->sum('sold');
            // $total_sold = $products->sum('total');
            
            view()->share('products', $products);
            $pdf = PDF::loadView('report.product-report-print', ['products'=>$products, 'start'=>$start, 'end'=>$end, 'total_count'=>$total_count, 'total_sold'=>$total_sold]);
            return $pdf->download('laporan-produk-diancagoods.pdf');
        }
        return redirect(route('administrator.login'));
    }

    // Export as Excel

    public function paymentReportExcel()
    {
    	if(Auth::guard('web')->check()) {
            $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';

            return Excel::download(new PaymentReport($start, $end), 'laporan-pembayaran-diancagoods.xlsx');
        }
        return redirect(route('administrator.login'));
    }

    public function allReportExcel()
    {
    	if(Auth::guard('web')->check()) {
            $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';

            return Excel::download(new TransactionReport($start, $end), 'laporan-transaksi-diancagoods.xlsx');
        }
        return redirect(route('administrator.login'));
    }

    public function salesReportExcel()
    {
    	if(Auth::guard('web')->check()) {
            $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
            
            return Excel::download(new SalesReport($start, $end), 'laporan-penjualan-diancagoods.xlsx');
        }
        return redirect(route('administrator.login'));
    }

    public function productReportExcel()
    {
    	if(Auth::guard('web')->check()) {
            $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
            
            return Excel::download(new ProductReport($start, $end), 'laporan-produk-diancagoods.xlsx');
        }
        return redirect(route('administrator.login'));
    }

    // Home Management
    public function homepageList(){
        if(Auth::guard('web')->check()){
            $product = Product::with('variant', 'images')->where('is_featured', 1)->orWhere('is_featured', 2)->orWhere('is_featured', 3)->orderBy('created_at', 'ASC')->get();
            $product_option = Product::with('variant', 'images')->where('is_featured', 0)->orderBy('name', 'ASC')->get();
            return view('admin.homepage-list', compact('product', 'product_option'));
        }
        return redirect(route('administrator.login'));
    }

    public function homepageCreate(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'type' => 'required',
                'product_select' => 'required'
            ]);

            try {
                $product = Product::where('id', $request->product_select)->first();
                $product->update([
                    'is_featured' => $request->type
                ]);
                
                return redirect(route('administrator.homepage'));
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }

    public function homepageChange($product_id)
    {
        $product = Product::with('variant', 'images')->where('id', $product_id)->first();
        return json_encode($product);
    }

    public function homepageUpdate(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'type' => 'required',
                'input_name' => 'required'
            ]);

            try {
                $product = Product::where('name', $request->input_name)->first();
                $product->update([
                    'is_featured' => $request->type
                ]);
                
                return redirect(route('administrator.homepage'));
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }

    public function homepageDelete(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'id' => 'integer'
            ]);

            try {
                $product = Product::where('id', $request->id)->first();
                $product->update([
                    'is_featured' => 0
                ]);
                
                return redirect(route('administrator.homepage'));
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }
}