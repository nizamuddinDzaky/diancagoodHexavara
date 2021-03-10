<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Customer;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index($status)
    {
        if(Auth::guard('customer')->check()) {
            if($status == 1) {
                $orders = Order::with('details.variant.product', 'details.review')->whereHas('details.review', function($query) {
                    return $query->where('status', 1)->orderBy('updated_at', 'DESC');
                })->where('customer_id', Auth::guard('customer')->user()->id)->get();

                return view('dianca.review-list', compact('orders'));
            } else if ($status == 0) {
                $orders = Order::with('details.variant.product')->whereHas('details.review', function($query) {
                    return $query->where('status', 0);
                })->where('customer_id', Auth::guard('customer')->user()->id)->get();

                return view('dianca.review-add', compact('orders'));
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
                $order_detail = OrderDetail::where('id', $request->order_detail_id)->first();
                $review = Review::where('order_detail_id', $order_detail->id)->first();
                if($review == NULL) {
                    Review::create([
                        'order_detail_id' => $order_detail->id,
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

                return redirect(route('reviews.list', ['status' => 1]));
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('customer.login'));
    }
}
