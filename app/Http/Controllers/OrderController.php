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
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    public function showCart()
    {
        if(Auth::guard('customer')->check()){
            $cart = Cart::with('details.variant.product')->where('customer_id', Auth::guard('customer')->user()->id)->first();
            // dd($cart);
            $cart_json = json_encode($cart);
            return view('dianca.cart', compact('cart', 'cart_json'));
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
        $carts_variant = CartDetail::where('id', $request->id)->first();
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

        $cart = Cart::with('details')->where('customer_id', Auth::guard('customer')->user()->id)->first();

        $total_cost = CartDetail::where('cart_id', $cart->id)->sum('price');
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
            $return['totalcost'] = $request->curr_total + ($request->qty * $product_variant->price);
            $return['qty'] = $request->curr_qty + $request->qty;
        } else if($request->add == 0) {
            $return['totalcost'] = $request->curr_total - ($request->qty * $product_variant->price);
            $return['qty'] = $request->curr_qty - $request->qty;
        }

        return json_encode($return, JSON_NUMERIC_CHECK);
    }

    public function checkout(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            $cart = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();

            $cart_arr = $request->input('cd');
            $total_cost = 0;
            $cart_detail = array();

            foreach($cart_arr as $cd) {
                $cart_detail[] = CartDetail::with('variant.product')->where('is_avail', 1)->where('id', $cd)->first();
            }
            
            foreach($cart_detail as $cd) {
                $total_cost += $cd->price;
            }
            
            $address = Address::with('district.city.province')->where('customer_id', auth()->guard('customer')->user()->id)->where('is_main', 1)->first();

            $provinces = Province::get();

            return view('dianca.checkout', compact('cart', 'cart_detail', 'address', 'total_cost', 'provinces'));
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

            $address = Address::create([
                'address_type' => $request->address_type,
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'district_id' => $request->district_id,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'is_main' => $request->is_main,
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
            $this->validate($request, [
                'courier' => 'required',
                'duration' => 'required',
                'address_id' => 'required|exists:addresses,id',
                'shipping_cost' => 'required',
                'subtotal' => 'required',
                'cd' => 'required'
            ]);

            $subtotal = $request->subtotal;
            $shipping_cost = $request->shipping_cost;
            $address_id = $request->address_id;
            $total_cost = $request->subtotal + $request->shipping_cost;
            $courier = $request->courier;
            $duration = $request->duration;
            $cart_detail = $request->input('cd');

            return view('dianca.payment', compact('subtotal', 'shipping_cost', 'address_id', 'total_cost', 'courier', 'duration', 'cart_detail'));
        }
    }

    public function checkoutProcess(Request $request)
    {
        $this->validate($request, [
            'payment_method' => 'required',
            'bank' => 'required',
            'courier' => 'required',
            'address_id' => 'required|exists:addresses,id',
            'duration' => 'required',
            'shipping_cost' => 'required',
            'subtotal' => 'required',
            'cd' => 'required'
        ]);

        $carts = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();
        $cart_arr = $request->input('cd');

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
            $order->invalid_at = $order_created->addMinutes(90)->toDateTimeString();
            $order->save();

            foreach ($cart_arr as $cd) {
                $cart_detail = CartDetail::where('id', $cd)->first();

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

                CartDetail::with('variant')->where('id', $cd)->delete();
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

            return view('dianca.payment-done', compact('order'));
        }
    }

    public function makePayment(Request $request)
    {
        if(Auth::guard('customer')->check()) {
            $this->validate($request, [
                'invoice' => 'required|exists:orders,invoice',
                'transfer_to' => 'required|string',
                'transfer_from_bank' => 'required|string',
                'transfer_from_account' => 'required|string',
                'name' => 'required|string',
                'amount' => 'required|integer',
                'date' => 'required'
            ]);

            try {
                $order = Order::where('invoice', $request->invoice)->first();
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

                    return redirect()->route('transaction.list', ['status' => 1])->with(['success' => 'Bukti Pembayaran Sedang Diproses.']);
                }
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
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
}
