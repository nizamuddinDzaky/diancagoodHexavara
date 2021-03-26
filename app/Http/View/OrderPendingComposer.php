<?php

namespace App\Http\View;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderPendingComposer
{
    public function compose(View $view)
    {
        if(Auth::guard('customer')->check()) {
            $view->with('order_pending', Order::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 0)->count());
        }
    }
}