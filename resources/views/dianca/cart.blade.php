@extends('layouts.store')

@section('title')
<title>Pembelian</title>
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            <form method="POST" action="{{ route('checkout') }}">
                @csrf
                <div class="row my-2">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inline">
                                    <input class="form-check-input primary-checkbox" type="checkbox" value="" id="select-all">
                                    <label class="form-check-label font-16" for="select-all">
                                        Pilih Semua Barang
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a class="float-right font-16 weight-600" style="color:#EB5757" onclick="deleteAll()">Hapus</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                            @forelse($cart->details as $cd)
                                <div class="form-check text-gray-2 my-4">
                                    <input class="form-check-input position-static align-top primary-checkbox" type="checkbox" name="cd[]" id="check{{ $cd->id }}" value="{{ $cd->id }}" onclick="selectCart({{ $cd->id }})">
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
                                                <div class="col-lg-6">
                                                    <div class="btn-group btn-group-vertical-center float-right">
                                                        <span class="product_count">
                                                            <button class="reduced items-count font-10" type="button" onclick="update({{ $cd->id }}, 0)">
                                                                <span class="material-icons md-10">remove</span>
                                                            </button>
                                                        </span>
                                                        <span class="product_count">
                                                            <input type="text" name="qty[]" id="qty{{ $cd->id }}" maxlength="3" value="{{ $cd->qty }}" style="height:26px;width:70px" class="input-text" required>
                                                        </span>
                                                        <span class="product_count">
                                                            <button class="increase items-count font-10" type="button" onclick="update({{ $cd->id }}, 1)">
                                                                <span class="material-icons md-10">add</span>
                                                            </button>
                                                        </span>
                                                        <a type="button" class="float-right px-2 muted"><i class="material-icons md-24 py-0">favorite</i></a>
                                                        <a type="button" class="float-right muted" onclick="removeFromCart({{ $cd->id }})"><i class="material-icons md-24 py-0">delete</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card shadow-1">
                            <div class="card-body font-18">
                                <h4 class="weight-600">Ringkasan Belanja</h4>
                                <hr>
                                <p>Total Harga<strong><span class="float-right" id="total_cost">Rp {{ number_format(0, 2, ',', '.') }}</span></strong></p>
                                <button class="btn btn-orange weight-600 btn-block font-18 py-2">Beli Sekarang (<span id="qty">{{ 0 }}</span>)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(':checkbox:checked').prop('checked', false); 
    });
    
    var myObj = {
        style: "currency",
        currency: "IDR"
    }

    function update(id, isIncrement) {
        var input = document.getElementById('qty'+id);
        if(isIncrement)
            input.value++;
        else
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
                var total_cost = 0;
                var qty = 0;
                res.details.forEach(function(cd) {
                    if($("#check"+cd.id).prop('checked')){
                        total_cost += parseInt(cd.price);
                        qty += parseInt(cd.qty);
                    }

                    if(cd.id == id) {
                        $("#subtotal"+cd.id).html(cd.price.toLocaleString("id-ID", myObj));
                    }
                })
                $("#total_cost").html(parseInt(total_cost).toLocaleString("id-ID", myObj));
                $("#qty").html(parseInt(qty));
            },
            error: function (xhr, status, err) {
                console.log(err);
            }
        })
    }

    $("#select-all").click(function() {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    function selectCart(id) {
        var input = document.getElementById('qty'+id);

        if($("#check"+id).prop('checked')) {
            $.ajax({
                type: "POST",
                url: "/cart/semi-update",
                data: {
                    add: 1,
                    id: id,
                    qty: input.value,
                    curr_qty: document.getElementById("qty").innerHTML,
                    curr_total: parseInt(document.getElementById("total_cost").innerHTML.replace(/[^0-9-,]/g, ''))
                },
                dataType: "JSON",
                success: function(res) {
                    $("#total_cost").html(res.totalcost.toLocaleString("id-ID", myObj));
                    $("#qty").html(res.qty);
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "/cart/semi-update",
                data: {
                    add: 0,
                    id: id,
                    qty: input.value,
                    curr_qty: document.getElementById("qty").innerHTML,
                    curr_total: parseInt(document.getElementById("total_cost").innerHTML.replace(/[^0-9-,]/g, ''))
                },
                dataType: "JSON",
                success: function(res) {
                    $("#total_cost").html(res.totalcost.toLocaleString("id-ID", myObj));
                    $("#qty").html(res.qty);
                }
            });
        }
    }

    function deleteAll() {

    }

    function removeFromCart(id) {

    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection