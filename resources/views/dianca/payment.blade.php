@extends('layouts.store')

@section('title')
<title>Pembelian</title>
@endsection

@section('content')
<section class="feature_product_area section_gap mt-4" style="height: 240px">
    <div class="main_box pt-4">
        <div class="container">
            <div class="row mb-2">
                <div class="main_title">
                    <h2>Pembayaran</h2>
                    <h5 class="pt-2">2 dari 2 langkah</h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-6 col-6 px-lg-1 px-3">
                    <hr class="rounded my-2 p-0 mx-0" style="border: 5px solid gray; background-color: gray">
                    <h6>1 Checkout</h6>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-6 px-lg-1 px-3">
                    <hr class="rounded my-2 p-0 mx-0" style="border: 5px solid #f37020; background-color: #f37020">
                    <h6><strong>2 Bayar</strong></h6>
                </div>
                <hr class="pb-2" style="border-color:F2F2F2">
            </div>
        </div>
    </div>
</section>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row pt-2">
                <div class="col-lg-8">
                    <div class="row py-2">
                        <div class="col-lg-12 pb-2">
                            <div class="card shadow-1">
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
                            <div class="card shadow-1">
                                <div class="card-body font-18">
                                    <h4 class="weight-600">Ringkasan Belanja</h4>
                                    <hr>
                                    <h5>Total Pembelian<strong><span class="float-right" id="total_cost">Rp {{ number_format($subtotal,  2, ',', '.') }}</span></strong></h5>
                                    <h5 class="text-orange">Potongan<strong><span class="float-right" id="promo">Rp {{number_format($promos, 2, ',', '.') }}</span></strong></h5>
                                    <h5>Ongkos Kirim<strong><span class="float-right" id="ongkir">Rp {{ number_format(17000,  2, ',', '.') }}</span></strong></h5>
                                    <hr>
                                    <h5 class="mb-3">Total Harga<strong><span class="float-right" id="total">Rp
                                                {{ number_format(($total_cost - $promos), 2, ',', '.') }}</span></strong></h5>
                                    <a type="button" id="submit_btn" class="btn btn-block btn-orange weight-600 font-18 py-2" aria-disabled="true">Bayar</a>
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
            Swal.fire({
                title: "Detail Tidak Lengkap",
                text: "Pilih metode pembayaran dan bank",
                icon: "warning",
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