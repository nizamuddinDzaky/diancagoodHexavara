<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Review;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status, Request $request)
    {
        if(Auth::guard('customer')->check()) {
            if($status != 5) {
                $orders = Order::with('details.variant.product.images', 'payment')->where('customer_id', Auth::guard('customer')->user()->id)->where('status', $status)->orderBy('created_at', 'DESC')->get();
                // $reviews = OrderDetail::with('order', 'review')->where('order_id', '$orders->id')->get();
            } else {
                $orders = Order::with('details.variant.product.images', 'payment')->where('customer_id', Auth::guard('customer')->user()->id)->orderBy('created_at', 'DESC')->get();
            }
            $str = NULL;
            // print_r($orders[3]);
            // die;
            // foreach($orders as $o){
            //     echo $od->details->count().'<br>';
            // }die;
            return view('dianca.transaction-list', compact('orders', 'str'));
        }
        return redirect(route('customer.login'));
    }

    public function getOrdersByDate(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            $orders = Order::with('details', 'payment')->where('customer_id', Auth::guard('customer')->user()->id)->whereDate('created_at', $start)->whereDate('updated_at', $end)->orderBy('updated_at', 'DESC')->get();

            return json_encode($orders);
        }
        return redirect(route('customer.login'));
    }

}
