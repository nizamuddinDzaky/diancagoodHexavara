<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\ProductVariant;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dianca.checkout');
    }

    public function payment()
    {
        return view('dianca.payment');
    }

    public function paymentDone()
    {
        return view('dianca.payment-done');
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

                    $cart->total_cost += $variant->price * $request->qty;
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
        $product_variant = ProductVariant::where('id', $request->id)->first();
        $carts_variant = CartDetail::where('cart_id', $cart->id)->where('product_variant_id', $request->id)->first();

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
        $return['total_cost'] = $cart->total_cost;
        $return['subtotal'] = $carts_variant->price;
        $return['variant'] = $carts_variant;

        return json_encode($return);
    }
}
