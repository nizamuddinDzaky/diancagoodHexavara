<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Promo;
use App\Models\PromoDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;


class PromoController extends Controller
{
    public function index($type)
    {
        if(Auth::guard('web')->check()) {
            $products = Product::with('variant')->orderBy('name', 'ASC')->get();
            if($type == "all") {
                $promos = Promo::with('details.variant.product')->orderBy('start_date', 'DESC')->orderBy('end_date', 'ASC')->paginate(10);
            } else {
                $promos = Promo::with('details.variant.product')->where('promo_type', strval($type))->orderBy('updated_at', 'DESC')->paginate(10);
            }
            return view('admin.promo-list', compact('promos', 'products'));
        }
        return redirect(route('administrator.login'));
    }

    public function create(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'type' => 'required|string',
                'name' => 'string',
                'payment_duration' => 'required|numeric',
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i:s',
                'end_date' => 'required|date',
                'end_time' => 'required|date_format:H:i:s',
                'value_type' => 'required|string',
                'value' => 'required|numeric',
                'product_variant' => 'required|array'
            ]);

            try {
                $promo = Promo::create([
                    'name' => $request->name,
                    'promo_type' => $request->type,
                    'value_type' => $request->value_type,
                    'payment_duration' => $request->payment_duration,
                    'value' => $request->value,
                    'start_date' => Carbon::createFromFormat('m/d/Y', $request->start_date),
                    'start_time' => Carbon::createFromFormat('H:i:s', $request->start_time, 'Asia/Jakarta'),
                    'end_date' => Carbon::createFromFormat('m/d/Y', $request->end_date),
                    'end_time' => Carbon::createFromFormat('H:i:s', $request->end_time, 'Asia/Jakarta'),
                    'is_published' => 0
                ]);

                foreach($request->product_variant as $key => $value) {
                    $detail[] = PromoDetail::create([
                        'promo_id' => $promo->id,
                        'product_variant_id' => $value
                    ]);
                }

                return redirect()->back()->with(['success' => 'Promo berhasil dihapus.']);
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }

    public function show($id)
    {
        $promo = Promo::with('details.variant.product.images')->where('id', $id)->first();
        return json_encode($promo);
    }

    public function update(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'type' => 'required|string',
                'name' => 'string',
                'payment_duration' => 'required|numeric',
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i:s',
                'end_date' => 'required|date',
                'end_time' => 'required|date_format:H:i:s',
                'value_type' => 'required|string',
                'value' => 'required|numeric',
                'product_variant' => 'required|array'
            ]);

            try {
                $promo = Promo::where('id', $request->promo_id)->first;
                $promo->update([
                    'name' => $request->name,
                    'promo_type' => $request->type,
                    'value_type' => $request->value_type,
                    'payment_duration' => $request->payment_duration,
                    'value' => $request->value,
                    'start_date' => Carbon::createFromFormat('m/d/Y', $request->start_date),
                    'start_time' => Carbon::createFromFormat('H:i:s', $request->start_time, 'Asia/Jakarta'),
                    'end_date' => Carbon::createFromFormat('m/d/Y', $request->end_date),
                    'end_time' => Carbon::createFromFormat('H:i:s', $request->end_time, 'Asia/Jakarta'),
                ]);

                PromoDetail::whereIn('promo_id', $promo->id)->delete();

                foreach($request->product_variant as $key => $value) {
                    PromoDetail::create([
                        'promo_id' => $promo->id,
                        'product_variant_id' => $value
                    ]);
                }

                return redirect()->back()->with(['success' => 'Promo berhasil diperbarui.']);
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }

    public function publish(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'id' => 'integer|exists:promos,id'
            ]);

            try {
                $promo = Promo::where('id', $request->id)->first();
                $promo->update(['is_published' => 1]);
                $promo->save();

                return redirect()->route('administrator.promo', 'all');
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }

    public function destroy(Request $request)
    {
        if(Auth::guard('web')->check()) {
            $this->validate($request, [
                'id' => 'integer|exists:promos,id'
            ]);

            try {
                $promo = Promo::where('id', $request->id)->first();
                $promo_details = PromoDetail::where('promo_id', $promo->id)->get();

                foreach($promo_details as $pd)
                    $pd->delete();
                    
                $promo->delete();

                return redirect()->back()->with(['success' => 'Promo berhasil dihapus.']);
            } catch(\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }
        return redirect(route('administrator.login'));
    }

    public function getPromoValue($promo_id, $variant_id)
    {
        $promo_detail = PromoDetail::with('promo')->where('promo_id', $promo_id)->where('product_variant_id', $variant_id)->first();
        return json_encode($promo_detail);
    }
}
