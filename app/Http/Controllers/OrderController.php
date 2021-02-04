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
    public function index()
    {
        if(auth()->guard('customer')->check()) {
            $carts = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();
            $carts_detail = CartDetail::with('variant.product')->where('is_avail', 1)->where('cart_id', $carts->id)->get();

            foreach($carts_detail as $cd) {
                $variants[] = ProductVariant::where('id', $cd->product_variant_id)->first();
            }
            
            $address = Address::where('customer_id', auth()->guard('customer')->user()->id)->where('is_main', 1)->first();

            return view('dianca.checkout', compact('carts', 'carts_detail', 'variants', 'address'));
        }
        
    }

    public function payment($invoice)
    {
        $order = Order::where('invoice', $invoice)->first();
        // return view('ecommerce.checkout_finish', compact('order'));
        return view('dianca.payment');
    }

    public function paymentDone()
    {
        return view('dianca.paymentDone');
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
        return redirect(route('checkout'));
    }

    public function checkout_process(Request $request)
    {
        $this->validate($request, [
            // 'courier' => 'required'
            'shipping_cost' => 'required'
        ]);

        $carts = Cart::where('customer_id', auth()->guard('customer')->user()->id)->first();
        $carts_detail = CartDetail::with('variant')->where('is_avail', 1)->where('cart_id', $carts->id)->get();

        foreach($carts_detail as $cd) {
            $variants[] = ProductVariant::where('id', $cd->product_variant_id)->first();
        }

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
                'subtotal' => $carts->total_cost,
                'total_cost' => $carts->total_cost + 17000,
                'shipping_cost' => $request->shipping_cost,
                'shipping' => 'JNT',
                'free_access' => false
            ]);

            foreach ($carts_detail as $row) {
                $variant = ProductVariant::where('id', $row->product_variant_id)->first();
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $row->product_variant_id,
                    'price' => $variant->price,
                    'qty' => $row->qty,
                    'weight' => $variant->weight
                ]);

                $variant->stock -= $row->qty;
                $variant->save();

                $row->delete();
            }

            DB::commit();

            return redirect(route('payment'));
            // return redirect(route('payment', $order->invoice));
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
