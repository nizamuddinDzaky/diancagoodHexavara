<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Address;
use App\Models\PromoDetail;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    public function showCart()
    {
        if(Auth::guard('customer')->check()){
            $session_cart = [];
            if(request()->session()->has('id_item_cart')){
                $session_cart = request()->session()->get('id_item_cart');    
            }

            $cart = Cart::with('details.variant.product', 'details.variant.promo_detail')->with('details', function($query) {
                $query->orderBy('created_at', 'desc');
            })->where('customer_id', Auth::guard('customer')->user()->id)->first();
            // echo count($cart);die;
            // print_r($cart->details[0]->variant->promo_detail);die;
            $str = NULL;
            $cart_json = json_encode($cart);
            return view('dianca.cart', compact('cart', 'cart_json', 'str', 'session_cart'));
        }
        return redirect(route('customer.login'));;
    }

    public function addToCart(Request $request)
    {
        if(Auth::guard('customer')->check()){
            $this->validate($request, [
                'product_variant_id' => 'required|int',
                'qty' => 'required|int'
            ]);

            $cart = Cart::with('details.variant.product.images')->where('customer_id', Auth::guard('customer')->user()->id)->first();
            
            $variant = ProductVariant::where('id', $request->product_variant_id)->first();

            if($variant->stock > 0) {
                // echo $cart->id;die;
                // var_dump(CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->exists());die;
                if(!CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->exists()) {
                    $cart_detail = CartDetail::create([
                        'cart_id' => $cart->id,
                        'product_variant_id' => $variant->id,
                        'qty' => $request->qty,
                        'price' => ($variant->price) * $request->qty,
                        'promo' => $variant->promo_price
                    ]);
    
                    $cart->total_cost += $cart_detail->price;
                    $cart->save();
                } else {
                    $cart_variant = CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->first();
                    $cart_variant->qty += $request->qty;
                    $cart_variant->price += ($variant->price) * $request->qty;
                    $cart_variant->promo += $variant->promo_price;
                    $cart_variant->save();

                    $cart->total_cost = CartDetail::where('cart_id', $cart->id)->sum('price');
                    $cart->total_promo = CartDetail::where('cart_id', $cart->id)->sum('promo');
                    $cart->save();
                }
                
                return redirect()->back()->with(['success' => 'Produk berhasil ditambahkan ke keranjang.']);
            }
            
            return redirect()->back()->with(['error' => 'Produk tidak dapat ditambahkan ke keranjang.']);
        }
        return redirect(route('customer.login'));
    }

    public function updateCart(Request $request)
    {
        $carts_variant = CartDetail::where('id', $request->id)->first();
        $product_variant = ProductVariant::where('id', $carts_variant->product_variant_id)->first();

        $carts_variant->update([
            'qty' => $request->qty,
            'price' => $request->qty * ($product_variant->price),
            'promo' => $request->qty * $product_variant->promo_price
        ]);

        if($product_variant->stock < $carts_variant->qty) {
            $carts_variant->is_avail = false;
        } else {
            $carts_variant->is_avail = true;
        }

        $carts_variant->save();

        $cart = Cart::with('details')->where('customer_id', Auth::guard('customer')->user()->id)->first();

        $total_cost = CartDetail::where('cart_id', $cart->id)->sum('price');
        $promos = CartDetail::where('cart_id', $cart->id)->sum('promo');
        $cart->total_cost = $total_cost;
        $cart->save();

        return json_encode($cart, JSON_NUMERIC_CHECK);
    }

    public function updateCartOrder(Request $request)
    {
        $cart = Cart::where('customer_id', Auth::guard('customer')->user()->id)->first();
        $carts_variant = CartDetail::where('cart_id', $cart->id)->where('id', $request->id)->first();
        $product_variant = ProductVariant::where('id', $carts_variant->product_variant_id)->first();

        $return = array();
        
        if($request->add == 1) {
            $return['totalcost'] = $request->curr_total + ($request->qty * ($product_variant->price - $product_variant->promo_price));
            $return['qty'] = $request->curr_qty + $request->qty;
        } else if($request->add == 0) {
            $return['totalcost'] = $request->curr_total - ($request->qty * ($product_variant->price - $product_variant->price));
            $return['qty'] = $request->curr_qty - $request->qty;
        }

        return json_encode($return, JSON_NUMERIC_CHECK);
    }

    public function submitItemCart(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            $cart = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();

            $cart_arr = $request->input('cd');
            $total_cost = 0;
            $cart_detail = array();
            $str = NULL;
            
            $request->session()->put('id_item_cart', $cart_arr);
            return redirect()->route('checkout');
            // foreach($cart_arr as $cd) {
            //     $cart_detail[] = CartDetail::with('variant.product')->where('is_avail', 1)->where('id', $cd)->first();
            // }
            // print_r($cart_arr);die;
            
            // foreach($cart_detail as $cd) {
            //     $total_cost += $cd->price;
            // }
            
            // $address = Address::with('district.city.province')->where('customer_id', auth()->guard('customer')->user()->id)->where('is_main', 1)->first();

            // $provinces = Province::get();

            // return view('dianca.checkout', compact('cart', 'cart_detail', 'address', 'total_cost', 'provinces', 'str'));
        }
    }

    public function changeAddress($id)
    {
        request()->session()->put('id_address', $id);
        return redirect()->route('checkout');
    }

    public function checkout(Request $request)
    {
        if(Auth::guard('customer')->check()) {

            if (!$request->session()->has('id_item_cart')) {
                return redirect()->route('home');
            }
            
            $cart = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();
            $cart_arr = $request->session()->get('id_item_cart');
            $total_cost = 0;
            $promos = 0;
            $cart_detail = array();
            $str = NULL;
            
            foreach($cart_arr as $cd) {
                $cart_detail[] = CartDetail::with('variant.product')->where('is_avail', 1)->where('id', $cd)->first();
            }
            
            foreach($cart_detail as $cd) {
                $total_cost += $cd->price;
                $promos += $cd->promo;
            }
            
            $address = Address::with('district.city.province')->where('customer_id', auth()->guard('customer')->user()->id);
            if ($request->session()->has('id_address')) {
                $address = $address->where('id' , $request->session()->get('id_address'));
            }else{
                $address = $address->where('is_main', 1);
            }
            $address = $address->first();
            $provinces = Province::get();

            return view('dianca.checkout', compact('cart', 'cart_detail', 'address', 'total_cost', 'promos', 'provinces', 'str'));
        }
    }

    public function address(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            $this->validate($request, [
                'address_type' => 'required|string',
                'receiver_name' => 'required|string',
                'receiver_phone' => 'required|string',
                'district_id' => 'required|exists:districts,id',
                'postal_code' => 'required|string',
                'address' => 'required|string',
                'is_main' => 'boolean',
                'customer_id' => 'required|exists:customers,id'
            ]);

            $countAddress = Address::where('customer_id', auth()->guard('customer')->user()->id)->count();

            $is_main = 0;
            
            if ($request->is_main == 1) {
                Address::where('customer_id', auth()->guard('customer')->user()->id)->update(['is_main'=>0]);
                $is_main = 1;
            }
            if ($countAddress == 0) {
                $is_main = 1;
            }
            // print_r($request->all());die;

            $address = Address::create([
                'province_id' => $request->province_id,
                'city_id' =>$request->city_id,
                'address_type' => $request->address_type,
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'district_id' => $request->district_id,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'is_main' => $is_main,
                'customer_id' => $request->customer_id
            ]);
            
            $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();
            $customer->update([
                'address' => 1
            ]);

            $customer->save();

            return json_encode($address);
        }
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id',
            'address_type' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_phone' => 'required|string',
            'district_id' => 'required|exists:districts,id',
            'postal_code' => 'required|string',
            'address' => 'required|string',
            'is_main' => 'boolean'
        ]);

        $address = Address::find($request->address_id);
        $address->update([
            'address_type' => $request->address_type,
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'district_id' => $request->district_id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'is_main' => $request->is_main
        ]);

        $address->save();

        $address_new = Address::with('district.city.province')->find($request->address_id);

        return json_encode($address_new);
    }

    public function payment(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            // dd($request);
            $this->validate($request, [
                'courier' => 'required',
                'duration' => 'required',
                'address_id' => 'required|exists:addresses,id',
                'shipping_cost' => 'required',
                'subtotal' => 'required',
                'promo' => 'integer'
            ]);

            $subtotal = $request->subtotal;
            $shipping_cost = $request->shipping_cost;
            $address_id = $request->address_id;
            $total_cost = $request->subtotal + $request->shipping_cost;
            $courier = $request->courier;
            $duration = $request->duration;
            $promos = $request->promo;
            $str = NULL;
            return view('dianca.payment', compact('subtotal', 'shipping_cost', 'address_id', 'total_cost', 'courier', 'duration', 'promos', 'str'));
        }
    }

    public function checkoutProcess(Request $request)
    {
        // echo "asd";die;
        $this->validate($request, [
            'payment_method' => 'required',
            'bank' => 'required',
            'courier' => 'required',
            'address_id' => 'required|exists:addresses,id',
            'duration' => 'required',
            'shipping_cost' => 'required',
            'subtotal' => 'required',
        ]);

        $carts = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();
        $cart_arr = $request->session()->get('id_item_cart');

        $address = Address::where('id', $request->address_id)->first();
        $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();

        try{
            $unique = rand(1, 99);
            $order = Order::create([
                'invoice' => Str::random(4) . '-' . time(),
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone_number,
                'address_id' => $request->address_id,
                'subtotal' => $request->subtotal,
                'unique' => $unique,
                'total_cost' => $request->subtotal + $request->shipping_cost + $unique,
                'shipping_cost' => $request->shipping_cost,
                'shipping' => $request->courier,
            ]);

            $order_created = Carbon::create($order->created_at->toDateTimeString());
            
            $limit_paymentduration = 90;
            $is_set_promo = false;
            $new_limit_paymentduration = 999999999999;
            foreach($cart_arr as $cd){
                $cart_detail = CartDetail::with('variant')->where('id', $cd)->first();
                $promo = PromoDetail::with('promo')->where('product_variant_id', $cart_detail->product_variant_id)->first();
                if(!$promo){
                    continue;
                }
                if($promo->promo->payment_duration < $new_limit_paymentduration){
                    $new_limit_paymentduration = $promo->promo->payment_duration;
                    $is_set_promo = true;
                }
            }
            if($is_set_promo){
                $limit_paymentduration = $new_limit_paymentduration;
            }
            
            $order->invalid_at = $order_created->addMinutes($limit_paymentduration)->toDateTimeString();
            $order->save();

            // print_r($order_created->addMinutes($promo->promo->payment_duration)->toDateTimeString());die;
            foreach ($cart_arr as $cd) {

                $variant = ProductVariant::where('id', $cart_detail->product_variant_id)->first();

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'price' => $variant->price,
                    'qty' => $cart_detail->qty,
                    'promo' => $cart_detail->promo * $cart_detail->qty,
                    'weight' => $variant->weight * $cart_detail->qty,
                ]);

                $variant->stock -= $cart_detail->qty;
                $variant->save();

                CartDetail::with('variant')->where('id', $cd)->delete();
            }

            if (request()->session()->has('id_item_cart')) {
                $request->session()->forget('id_item_cart');
                $request->session()->save();
            }

            if (request()->session()->has('id_address')) {
                $request->session()->forget('id_address');
                $request->session()->save();
            }

            $payment = Payment::create([
                'order_id' => $order->id,
                'transfer_to' => $request->bank,
                'method' => $request->payment_method
            ]);

            return redirect()->route('payment.done', ['id' => $order->id]);
        }catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function paymentDone($id)
    {
        if(Auth::guard('customer')->check()) {
            $order = Order::with('payment')->where('customer_id', Auth::guard('customer')->user()->id)->where('id', $id)->first();
            $str = NULL;
            return view('dianca.payment-done', compact('order', 'str'));
        }
    }

    public function makePayment(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            $this->validate($request, [
                'invoice' => 'required|exists:orders,invoice',
                'order_id' => 'required|exists:orders,id',
                'transfer_to' => 'required|string',
                'transfer_from_bank' => 'required|string',
                'transfer_from_account' => 'required|string',
                'name' => 'required|string',
                'amount' => 'required|integer',
                'date' => 'required',
                'proof' => 'image|mimes:jpg,png,jpeg'
            ]);

            try {
                $order = Order::where('id', $request->order_id)->first();
                $payment = Payment::where('order_id', $order->id)->first();

                $order_invalid = Carbon::createFromFormat('Y-m-d H:i:s', $order->invalid_at);
                $now = Carbon::now();

                if($now->isBefore($order_invalid) && $order->status != 5) {
                    $payment->update([
                        'transfer_from_bank' => $request->transfer_from_bank,
                        'transfer_from_account' => $request->transfer_from_account,
                        'name' => $request->name,
                        'amount' => $request->amount,
                        'transfer_date' => Carbon::createFromFormat('m/d/Y', $request->date),
                        'status' => 1,
                    ]);
                    $payment->save();

                    $order->update(['status' => 1]);
                    $order->save();

                    if($request->hasFile('proof')) {
                        $file = $request->file('proof');
                        $filename = time() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('public/payment', $filename);

                        $payment->update(['proof' => $filename]);
                    }
                    return redirect()->route('transaction.list', ['status' => 0])->with(['success' => 'Bukti Pembayaran Sedang Diproses.']);
                }
                return redirect()->route('transaction.list', ['status' => 0])->with(['error' => 'Lewat Batas Pembayaran.']);
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
    }

    public function cancelOrder($id)
    {
        if(Auth::guard('customer')->check()) {
            try {
                $order = Order::with('payment', 'details')->where('id', $id)->first();
                if($order->status == 0){
                    $order_details = OrderDetail::where('order_id', $order->id)->get();
                    foreach($order_details as $od){
                        $pv = ProductVariant::where('id', $od->product_variant_id)->first();
                        $pv->stock += $od->qty;
                    }
                    $order->status = 4;
                    $order->save();

                    return redirect()->route('transaction.list', ['status' => 4])->with(['success' => 'Pesanan Berhasil Dihapus.']);
                }
            } catch(\Ecception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('customer.login'));
    }
    
    public function quickAddToCart(Request $request, $id)
    {
        if(!Auth::guard('customer')->check()){
            if(!$request->ajax()){
                return redirect(route('customer.login'));
            }else{
                $response = [
                    'status' => false,
                    'message' => "Silahkan Login"
                ];
                return json_encode($response);
            }
        }
        
        $cart = Cart::with('details.variant.product.images')->where('customer_id', Auth::guard('customer')->user()->id)->first();
        
        $variant = ProductVariant::where('id', $id)->first();
        if($variant->stock < 0){
            $message = 'Produk tidak dapat ditambahkan ke keranjang.';
            if(!$request->ajax()){
                return redirect()->back()->with(['error' => $message]);
            }else{
                $response = [
                    'status' => false,
                    'message' => $message
                ];
                return json_encode($response);
            }
        }

        if(!CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->exists()) {
            $cart_detail = CartDetail::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variant->id,
                'qty' => 1,
                'price' => $variant->price * 1,
                'promo' => $variant->promo_price * 1
            ]);
            $cart->total_cost += $cart_detail->price;
        } else {
            $cart_variant = CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->first();
            $cart_variant->qty += 1;
            $cart_variant->price += $variant->price * 1;
            $cart_variant->promo += $variant->promo_price * 1;
            $cart_variant->save();
            $cart->total_cost = CartDetail::where('cart_id', $cart->id)->sum('price');
        }
        $cart->save();
        $new_cart = Cart::with('details.variant.product.images')->where('customer_id', Auth::guard('customer')->user()->id)->first();
        $qty = $new_cart->details->sum('qty');
        if(!$request->ajax()){
            return redirect()->route('cart.show', array('qty' => $qty));
        }else{
            $response = [
                'status' => true,
                'message' => "Berhasil Menambahkan Keranjang",
                'qty' => $qty
            ];
            return json_encode($response);
        }
        // if(Auth::guard('customer')->check()){
        //     $cart = Cart::with('details.variant.product.images')->where('customer_id', Auth::guard('customer')->user()->id)->first();
            
        //     $variant = ProductVariant::where('id', $id)->first();

        //     if($variant->stock > 0) {
        //         if(!CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->exists()) {
        //             $cart_detail = CartDetail::create([
        //                 'cart_id' => $cart->id,
        //                 'product_variant_id' => $variant->id,
        //                 'qty' => 1,
        //                 'price' => $variant->price * 1
        //             ]);
    
        //             $cart->total_cost += $cart_detail->price;
        //             $cart->save();
        //         } else {
        //             $cart_variant = CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->first();
        //             $cart_variant->qty += 1;
        //             $cart_variant->price += $variant->price * 1;
        //             $cart_variant->save();

        //             $cart->total_cost = CartDetail::where('cart_id', $cart->id)->sum('price');
        //             $cart->save();
        //         }
        //         // echo $cart->details->sum('qty');die;
        //         return 
        //     }
            
        //     return redirect()->back()->with(['error' => 'Produk tidak dapat ditambahkan ke keranjang.']);
        // }
        // ;
    }

    public function getCourier(Request $request)
    {
        $this->validate($request, [
            'destination' => 'required',
            'weight' => 'required|integer'
        ]);

        $url = 'https://ruangapi.com/api/v1/shipping';
        $client = new Client();
        $response = $client->request('POST', $url, [
            'headers' => [
                'Authorization' => 'd1JlYPgwNExLRQl6jUSyfZOCoN7SxpBk8bU6gN3D'
            ],
            'form_params' => [
                'origin' => 22,
                'destination' => $request->destination,
                'weight' => $request->weight,
                'courier' => 'jnt,sicepat'
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    public function removeFromCart(Request $request)
    {
        if(Auth::guard('customer')->check) {
            $this->validate($request, [
                'id' => 'array'
            ]);

            foreach($request->id as $id) {
                $cart = Cart::where('customer_id', Auth::guard('customer')->user()->id)->first();
                $cart_detail = CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $id)->first();
                $cart->total_cost -= $cart_detail->price;
                $cart->save();

                $cart_detail->delete();
            }

            return redirect()->back()->with(['success' => 'Produk dihapus dari keranjang!']);
        }
        return redirect(route('customer.login'));
    }
    
    public function deleteCart($id)
    {
        if(Auth::guard('customer')->check()){
            
            if(request()->session()->has('id_item_cart')){
                $session_cart = request()->session()->get('id_item_cart');    
                $key = array_search($id,$session_cart);
                if(!is_bool($key)){
                    unset($session_cart[$key]);
                }
                if(count($session_cart) == 0 ){
                    request()->session()->forget('id_item_cart');
                    request()->session()->save();
                }else{
                    request()->session()->put('id_item_cart', $session_cart);
                }
            }
            $cart = CartDetail::find($id);
            $cart->delete();
            return redirect()->back();
        }
    }

    public function deleteMultipleCart(Request $request)
    {
        $arrayId = explode(',', $request['item-cart']);
        if(Auth::guard('customer')->check()){

            if(request()->session()->has('id_item_cart')){
                $session_cart = request()->session()->get('id_item_cart');    
                foreach($arrayId as $id){
                    $key = array_search($id,$session_cart);
                    if(!is_bool($key)){
                        unset($session_cart[$key]);
                    }
                }
                // echo count($session_cart);die;
                if(count($session_cart) == 0 ){
                    request()->session()->forget('id_item_cart');
                    request()->session()->save();
                }else{
                    request()->session()->put('id_item_cart', $session_cart);
                }
            }
            $cart = CartDetail::whereIn('id', $arrayId);
            $cart->delete();
            return redirect()->back();
        }
        // echo "string";
    }

    public function getCities()
    {
        $cities = City::where('province_id', request()->province_id)->get();
        return json_encode($cities);
    }

    public function getDistricts()
    {
        $districts = District::where('city_id', request()->city_id)->get();
        return json_encode($districts);
    }

    public function getOrderDetail($id)
    {
        $order = Order::with('details.variant.product.images', 'payment', 'address')->where('id', $id)->first();
        return json_encode($order);
    }
}
