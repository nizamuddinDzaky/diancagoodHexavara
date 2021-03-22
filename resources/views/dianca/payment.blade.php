@extends('layouts.store')

@section('title')
<title>Pembelian</title>
@endsection

@section('content')
<section class="feature_product_area section_gap mt-4" style="height: 240px">
    <div class="main_box pt-4">
        <div class="container">
            <div class="row my-2">
                <div class="main_title">
                    <h2 class="pl-3">Pembayaran</h2>
                    <h5 class="pl-3 pt-2">2 dari 2 langkah</h5>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-4">
                    <hr class="rounded" style="border: 5px solid orange">
                    <h6>1 Checkout</h6>
                </div>
                <div class="col-lg-4">
                    <hr class="rounded" style="border: 5px solid orange">
                    <h6>2 Bayar</h6>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <hr class="pb-2" style="border-color:F2F2F2">
</div>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row pt-2 pl-2">
                <div class="col-lg-8">
                    <div class="row py-2">
                        <div class="col-lg-12 pb-2">
                            <div class="card shadow-1" style="width: 47rem">
                                <div class="card-body">
                                    <form action="{{ route('checkout.process') }}" method="POST" id="payment-form">
                                        @csrf
                                        <div class="form-group">
                                            <label>Pilih Metode Pembayaran</label><br>
                                            <select id="payment_method" name="payment_method" class="form-control"
                                                style="background: #F2F2F2">
                                                <option value="Transfer" selected>Bank Transfer</option>
                                                <option value="">...</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pilih Bank</label><br>
                                            <select id="bank" name="bank" class="form-control"
                                                style="background: #F2F2F2">
                                                <option value="BNI" selected>Bank Negara Indonesia</option>
                                                <option value="">...</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="courier" value="{{ $courier }}">
                                        <input type="hidden" name="duration" value="{{ $duration }}">
                                        <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                                        <input type="hidden" name="shipping_cost" value="{{ $shipping_cost }}">
                                        <input type="hidden" name="address_id" value="{{ $address_id }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row py-2">
                        <div class="col-lg-12 pb-4">
                            <div class="card shadow-1" style="width: 22rem; height:20rem">
                                <div class="row px-4 py-4 ml-2" style="height: 50px">
                                    <div class="">
                                        <h4><strong>Ringkasan Belanja</strong></h4>
                                    </div>
                                </div>
                                <div class="container">
                                    <hr class="" style="border-color:F2F2F2">
                                </div>
                                <div class="row px-4 py-2">
                                    <div class="col-lg-6">
                                        <div class="row ml-2">
                                            <h5>Total Harga</h5>
                                        </div>
                                        <div class="row ml-2 pt-1 pb-2">
                                            <h5>Ongkos Kirim</h5>
                                        </div>
                                        <div class="row ml-2 pt-3">
                                            <h5>Total Tagihan</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mr-2 float-right">
                                            <h5>Rp {{number_format($subtotal, 2, ',', '.')}}</h5>
                                        </div>
                                        <div class="row mr-2 pt-1 pb-2 float-right">
                                            <h5>Rp {{ number_format($shipping_cost, 2, ',', '.') }}</h5>
                                        </div>
                                        <br>
                                        <div class="row mr-2 pt-3 float-right">
                                            <h5><strong>Rp {{number_format($total_cost, 2, ',', '.')}}</strong></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center pt-4">
                                    <div class="col-lg-10">
                                        <a type="button" id="submit_btn" class="btn btn-block btn-orange" aria-disabled="true">Bayar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#submit_btn").on('click', function(e) {
        e.preventDefault();
        if($("#payment_method").val() == "" || $("#bank").val() == ""){
            swal({
                title: "Detail Tidak Lengkap",
                text: "Pilih metode pembayaran dan bank",
                type: "warning",
                reverseButtons: !0
            }).then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            })
        } else {
            $("#payment-form").submit();
        }
    })
</script>
@endsection