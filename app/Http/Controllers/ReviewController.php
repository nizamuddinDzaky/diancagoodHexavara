<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Customer;
use App\Models\Review;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function index()
    {
        if(Auth::guard('customer')->check()) {
            
            if (request()->from_date != '' && request()->to_date != '') {
                $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
                $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
                $orders = Order::with('details.variant.product')->where('status', 3)->where('customer_id', Auth::guard('customer')->user()->id)->whereBetween('created_at', [$start, $end])->get();

                return view('dianca.review-add', compact('orders'));
            }

            else{
                $orders = Order::with('details.variant.product', 'details.review')->where('status', 3)->where('customer_id', Auth::guard('customer')->user()->id)->get();
                $jumlah = 0;
                foreach ($orders as $f) {
                    $jumlah += OrderDetail::with('order')->where('review_status', 0)->where('order_id', $f->id)->count();
                }
                
                // $jumlah = OrderDetail::with('order')->where('review_status', 0)->where('order_id', $orders->id)->count();
                return view('dianca.review-add', compact('orders', 'jumlah'));
            }
           
        }
        return redirect(route('customer.login'));
    }

    public function reviewDone()
    {
        if(Auth::guard('customer')->check()) {
            
            if (request()->from_date != '' && request()->to_date != '') {
                $start = Carbon::parse(request()->from_date)->format('Y-m-d') . ' 00:00:01';
                $end = Carbon::parse(request()->to_date)->format('Y-m-d') . ' 23:59:59';
                $orders = Order::with('details.variant.product')->where('status', 3)->where('customer_id', Auth::guard('customer')->user()->id)->whereBetween('created_at', [$start, $end])->get();

                return view('dianca.review-list', compact('orders'));
            }

            else{
                $orders = Order::with('details.variant.product')->whereHas('details.review', function($query) {
                    return $query->where('status', 1);
                })->where('customer_id', Auth::guard('customer')->user()->id)->where('status', 3)->get();
                

                return view('dianca.review-list', compact('orders'));
            }
        }
        return redirect(route('customer.login'));
    }
    
    public function create(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            $this->validate($request, [
                'order_detail_id' => 'required|exists:order_details,id',
                'rate' => 'required|numeric|between:0,5.0',
                'text' => 'nullable|string'
            ]);

            try {
                $order_detail = OrderDetail::where('id', $request->order_detail_id)->where('review_status', 0)->first();
                $variant = ProductVariant::where('id', $order_detail->product_variant_id)->first();
                $product = Product::where('id', $variant->product_id)->first();
                $review = Review::where('order_detail_id', $order_detail->id)->first();
                if($review == NULL) {
                    Review::create([
                        'order_detail_id' => $order_detail->id,
                        'product_id' => $product->id,
                        'product_variant_id' => $order_detail->product_variant_id,
                        'customer_id' => Auth::guard('customer')->user()->id,
                        'text' => $request->text,
                        'rate' => $request->rate,
                        'status' => 1
                    ]);
                } else {
                    $review->update([
                        'rate' => $request->rate,
                        'text' => $request->text,
                        'status' => 1,
                    ]);
                }
                $order_detail->update([
                    'review_status' => 1
                ]);

                $count = Review::with('product_variant', 'customer', 'order_detail')->where('product_id', $product->id)->count();
                $sum = Review::with('product_variant', 'customer', 'order_detail')->where('product_id', $product->id)->sum('rate');
                $rating = $sum/$count;

                $product->update([
                    'rate' => $rating
                ]);
                
                return redirect(route('reviews.done'));
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('customer.login'));
    }
}
