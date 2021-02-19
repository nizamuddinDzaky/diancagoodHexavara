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
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Address;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            $cart = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();

            $cart_arr = $request->input('cd');
            $total_cost = 0;

            foreach($cart_arr as $cd) {
                $cart_detail[] = CartDetail::with('variant.product')->where('is_avail', 1)->where('id', $cd)->first();
            }
            
            foreach($cart_detail as $cd) {
                $total_cost += $cd->price;
            }
            
            $address = Address::where('customer_id', auth()->guard('customer')->user()->id)->where('is_main', 1)->first();

            return view('dianca.checkout', compact('cart', 'cart_detail', 'address', 'total_cost'));
        }
        
    }

    public function payment($id)
    {
        if(Auth::guard('customer')->check()) {
            $order = Order::where('customer_id', Auth::guard('customer')->user()->id)->where('id', $id)->first();
            $total_cost = $order->subtotal;
            $qty = OrderDetail::where('order_id', $id)->sum('qty');
            return view('dianca.payment', compact('id', 'total_cost', 'qty'));
        }
    }

    public function paymentDone($id)
    {
        if(Auth::guard('customer')->check()) {
            $order = Order::where('customer_id', Auth::guard('customer')->user()->id)->where('id', $id)->first();

            $order_details = OrderDetail::where('order_id', $id)->get();

            $cart = Cart::where('customer_id', Auth::guard('customer')->user()->id)->first();

            foreach($order_details as $od) {
                CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $od->product_variant_id)->delete();
            }

            $cart->total_cost = CartDetail::where('cart_id', $cart->id)->sum('price');
            $cart->save();

            return view('dianca.payment-done');
        }
    }

    public function address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_type' => 'required',
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'address' => 'required'
        ]);

        $address = Address::create([
            'address_type' => $request->address_type,
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'is_main' => true,
            'customer_id' => $request->customer_id
        ]);
        
        $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();
        $customer->update([
            'address' => 1
        ]);
        // auth()->guard('customer')->user()->address = 1;
        // return json_encode($orders);
        // return redirect(route('checkout'));
    }

    public function updateAddress(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address_type' => 'required',
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'address' => 'required'
        ]);

        $address = Address::find($id);
        $address->update([
            'address_type' => $request->address_type,
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'is_main' => true
        ]);

        return redirect(route('checkout'));
    }

    public function checkout_process(Request $request)
    {
        $this->validate($request, [
            'courier' => 'required',
            'duration' => 'required',
            'shipping_cost' => 'required',
            'subtotal' => 'required',
            'cd' => 'required'
        ]);

        $carts = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();
        $cart_arr = $request->input('cd');

        $address = Address::where('customer_id', auth()->guard('customer')->user()->id)->where('is_main', 1)->first();
        $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();

        DB::beginTransaction();
        try{
            // $shipping = explode('-', $request->courier);
            $order = Order::create([
                'invoice' => Str::random(4) . '-' . time(),
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone_number,
                'customer_address' => $address->address,
                'district_id' => 1,
                'subtotal' => $request->subtotal,
                'total_cost' => $request->total_cost + $request->shipping_cost,
                'shipping_cost' => $request->shipping_cost,
                'shipping' => $request->courier,
            ]);

            foreach ($cart_arr as $cd) {
                $cart_detail = CartDetail::with('variant')->where('is_avail', 1)->where('id', $cd)->first();
                $variant = ProductVariant::where('id', $cart_detail->product_variant_id)->first();

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'price' => $variant->price,
                    'qty' => $cart_detail->qty,
                    'weight' => $variant->weight * $cart_detail->qty,
                ]);

                $variant->stock -= $cart_detail->qty;
                $variant->save();

                $cart_detail->delete();
            }

            DB::commit();

            return redirect(route('payment', ['id' => $order->id]));
            // return redirect(route('payment', $order->invoice));
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function showCart()
    {
        if(Auth::guard('customer')->check()){
            $cart = Cart::with('details.variant.product')->where('customer_id', Auth::guard('customer')->user()->id)->first();
            // dd($cart);
            return view('dianca.cart', compact('cart'));
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
                if(!CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->exists()) {
                    $cart_detail = CartDetail::create([
                        'cart_id' => $cart->id,
                        'product_variant_id' => $variant->id,
                        'qty' => $request->qty,
                        'price' => $variant->price * $request->qty
                    ]);
    
                    $cart->total_cost += $cart_detail->price;
                    $cart->save();
                } else {
                    $cart_variant = CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $variant->id)->first();
                    $cart_variant->qty += $request->qty;
                    $cart_variant->price += $variant->price * $request->qty;
                    $cart_variant->save();

                    $cart->total_cost = CartDetail::where('cart_id', $cart->id)->sum('price');
                    $cart->save();
                }
                
                return redirect()->back()->with(['success' => 'Produk berhasil ditambahkan ke keranjang.']);
            }
            
            return redirect()->back()->with(['error' => 'Produk tidak dapat ditambahkan ke keranjang.']);
        }
        return redirect(route('customer.login'));;
    }

    public function updateCart(Request $request)
    {
        $cart = Cart::where('customer_id', Auth::guard('customer')->user()->id)->first();
        $carts_variant = CartDetail::where('cart_id', $cart->id)->where('id', $request->id)->first();
        $product_variant = ProductVariant::where('id', $carts_variant->product_variant_id)->first();

        $carts_variant->update([
            'qty' => $request->qty,
            'price' => $request->qty * $product_variant->price
        ]);

        if($product_variant->stock < $carts_variant->qty) {
            $carts_variant->is_avail = false;
        } else {
            $carts_variant->is_avail = true;
        }

        $carts_variant->save();

        $total_cost = CartDetail::where('cart_id', $cart->id)->sum('price');
        $cart->total_cost = $total_cost;
        $cart->save();

        $return = array();
        $return['totalcost'] = $cart->total_cost;
        $return['subtotal'] = $carts_variant->price;
        $return['variant'] = $carts_variant;
        $return['qty'] = $carts_variant->sum('qty');

        return json_encode($return, JSON_NUMERIC_CHECK);
    }

    public function updateCartOrder(Request $request)
    {
        $cart = Cart::where('customer_id', Auth::guard('customer')->user()->id)->first();
        $carts_variant = CartDetail::where('cart_id', $cart->id)->where('id', $request->id)->first();
        $product_variant = ProductVariant::where('id', $carts_variant->product_variant_id)->first();

        $return = array();
        
        if($request->add == 1) {
            $return['totalcost'] = $request->curr_total + ($request->qty * $product_variant->price);
            $return['qty'] = $request->curr_qty + $request->qty;
        } else if($request->add == 0) {
            $return['totalcost'] = $request->curr_total - ($request->qty * $product_variant->price);
            $return['qty'] = $request->curr_qty - $request->qty;
        }

        return json_encode($return, JSON_NUMERIC_CHECK);
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
}
