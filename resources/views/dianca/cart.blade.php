@extends('layouts.store')

@section('title')
    <title>Pembelian</title>
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            <div class="row my-2">
                <div class="col-lg-8">
                    <div class="form-check text-gray-2">
                        <input class="form-check-input primary-checkbox" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label font-16 align-middle" for="flexCheckDefault">
                            Pilih Semua Barang
                        </label>
                        <span class="float-right font-16 weight-600" style="color:#EB5757">Hapus</span>
                    </div>
                    <hr>
                    <form method="POST" action="{{ route('cart.update') }}">
                        @csrf
                        @forelse($cart->details as $cd)
                        <div class="form-check text-gray-2 my-4">
                            <input class="form-check-input position-static align-top primary-checkbox" type="checkbox" name="cd[]" value="{{ $cd->id }}">
                            <div class="card cart-card shadow-1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="{{ asset('storage/products/' . $cd->variant->product->images->first()->filename) }}" width="130px" height="130px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <h4 class="weight-600">{{ $cd->variant->product->name }}</h4>
                                            <p>{{ $cd->variant->weight }}</p>
                                            <p>Rp {{ number_format($cd->variant->price, 2, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-6 font-16">
                                            <p class="align-items-center">Sub Total Harga: <strong><span id="subtotal{{ $cd->id }}">Rp {{ number_format($cd->variant->price * $cd->qty, 2, ',', '.') }}</span></strong></p>
                                        </div>
                                        <div class="col-lg-6 align-middle">
                                            <div class="btn-group btn-group-vertical-center float-right">
                                                <span class="product_count">
                                                    <button class="reduced items-count font-10" type="button" onclick="decrement({{ $cd->id}})">
                                                        <span class="material-icons md-10">remove</span>
                                                    </button>
                                                </span>
                                                <span class="product_count">
                                                    <input type="text" name="qty[]" id="qty{{ $cd->id }}" maxlength="12" value="{{ $cd->qty }}" style="height:26px;width:70px" class="input-text" required>
                                                </span>
                                                <span class="product_count">
                                                    <button class="increase items-count font-10" type="button" onclick="increment({{ $cd->id}})">
                                                        <span class="material-icons md-10">add</span>
                                                    </button>
                                                </span>
                                                <a type="button" class="float-right px-2 muted"><i class="material-icons md-24">favorite</i></a>
                                                <a type="button" class="float-right muted"><i class="material-icons md-24">delete</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-1">
                        <div class="card-body font-18">
                            <h4>Ringkasan Belanja</h4>
                            <hr>
                            <p>Total Harga<span class="float-right"><strong>Rp {{ number_format($cart->total_cost, 2, ',', '.') }}</strong></span></p>
                            <a type="button" href="#" class="btn btn-orange weight-600 btn-block font-18 py-2">Beli Sekarang (<span>{{ $cart->details->sum('qty') }}</span>)</a>
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
    var myObj = {
        style: "currency",
        currency: "IDR"
    }

    function increment(id) {
        var input = document.getElementById('qty'+id);
        input.value++;

        $.ajax({
            type: "POST",
            url: "/cart/update",
            data: {
                id: id,
                qty: input.value
            },
            dataType: "JSON",
            success: function(res) {
                $("#subtotal"+id).html(res.subtotal.toLocaleString("id-ID", myObj));
            },
            error: function (xhr, status, err) {
                console.log(err);
            }
        })
    }

    function decrement(id) {
        var input = document.getElementById('qty'+id);
        if(input.value - 1 > 0){
            input.value--;

            $.ajax({
                type: "POST",
                url: "/cart/update",
                data: {
                    id: id,
                    qty: input.value
                },
                dataType: "JSON",
                success: function(res) {
                    $("#subtotal"+id).html(res.subtotal.toLocaleString("id-ID", myObj));
                },
                error: function (xhr, status, err) {
                    console.log(err);
                }
            })
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection