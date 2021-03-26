@extends('layouts.store')

@section('title')
<title>Pembelian</title>
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            <form method="post" action="{{ route('delete.multiple.cart') }}" id="form-item-cart" class="hidden">
                @csrf
                <input type="hidden" name="item-cart" id="item-cart">
            </form>
            <form method="POST" action="{{ route('checkout.submit-item-cart') }}" id="checkout-form">
                @csrf
                <div class="row my-2">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inline px-lg-0 px-4">
                                    <input class="form-check-input primary-checkbox" type="checkbox" value=""
                                        id="select-all">
                                    <label class="form-check-label font-16" for="select-all">
                                        Pilih Semua Barang
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a class="float-right font-16 weight-600" style="color:#EB5757; cursor: pointer;" onclick="deleteAll()">Hapus</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                @forelse($cart->details as $cd)
                                <div class="form-check text-gray-2 my-4 card-item-cart">
                                    <input class="form-check-input position-static align-top primary-checkbox cb-item-cart"
                                        type="checkbox" name="cd[]" id="check{{ $cd->id }}" value="{{ $cd->id }}" data-id="{{$cd->id}}" 
                                        data-price="{{ ($cd->variant->price) }}" data-promo="{{ $cd->promo }}">
                                    <div class="card cart-card shadow-1 w-90">
                                        <div class="card-body">
                                            <div class="row">
                                                    <div class="d-flex prod-in-card">
                                                        <img src="{{ asset('storage/products/' . $cd->variant->product->images->first()->filename) }}" class="product-img-sm">
                                                        <div class="prod-in-card-details">
                                                            <h4 class="weight-600 text-truncate">{{ $cd->variant->product->name }}</h4>
                                                            <p>Varian {{ $cd->variant->name }}</p>
                                                            <p>Rp {{ number_format(($cd->variant->price - $cd->variant->promo_price), 2, ',', '.') }}<span class="d-inline-flex align-self-center ml-2" style="text-decoration:line-through;"><small>Rp {{ number_format($cd->variant->price, 2, ',', '.') }}</small></span></p>
                                                        </div>
                                                    </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-6 prod-name">
                                                    <p>Sub Total Harga: <strong><span
                                                                id="subtotal{{ $cd->id }}">Rp
                                                                {{ number_format(($cd->price - $cd->promo), 2, ',', '.') }}</span></strong>
                                                    </p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="btn-group btn-group-vertical-center float-right div-qty">
                                                        <span class="product_count">
                                                            <button class="reduced items-count font-10 btn-decrement" type="button">
                                                                <span class="material-icons md-10">remove</span>
                                                            </button>
                                                        </span>
                                                        <span class="product_count">
                                                            <input type="text" name="qty[]" id="qty{{ $cd->id }}"
                                                                maxlength="3" value="{{ $cd->qty }}" data-id="{{ $cd->id }}"
                                                                style="height:26px;width:70px" class="input-text input-qty" 
                                                                required>
                                                        </span>
                                                        <span class="product_count">
                                                            <button class="increase items-count font-10 btn-increment" type="button" >
                                                                <span class="material-icons md-10">add</span>
                                                            </button>
                                                        </span>
                                                        <a type="button" class="float-right px-2 muted"><i class="material-icons md-24 py-0">favorite</i></a>
                                                        <a type="button" class="float-right muted delete-cart" data-id = "{{ $cd->id }}" data-url-delete="{{ route('delete.cart', ['id'=>$cd->id]) }}" data-product-name="{{ $cd->variant->product->name }}"><i class="material-icons md-24 py-0">delete</i></a>
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
                                <h5>Total Pembelian<strong><span class="float-right" id="total_cost">Rp {{ number_format(0,  2, ',', '.') }}</span></strong></h5>
                                <h5 class="text-orange">Potongan<strong><span class="float-right" id="promo">Rp {{number_format(0, 2, ',', '.') }}</span></strong></h5>
                                <hr>
                                <h5 class="mb-3">Total Harga<strong><span class="float-right" id="total">Rp
                                            {{ number_format(0, 2, ',', '.') }}</span></strong></h5>
                                <button type="button" id="continue"
                                    class="btn btn-orange weight-600 btn-block font-18 py-2">Beli Sekarang (<span
                                        id="qty">{{ 0 }}</span>)</a>
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
    var selected_category = @json($session_cart);
    $(document).ready(function() {
        set_cart_item();
    });

    function set_cart_item(){
        $('.cb-item-cart').each(function () {
            let id = $(this).data('id');
            if(selected_category.indexOf(id.toString()) != -1){
                $(this).prop('checked', true);
            }
        });
        count_selected_cart();
    }

    var myObj = {
        style: "currency",
        currency: "IDR"
    }

    function update(id, value) {
        $.ajax({
            type: "POST",
            url: "/cart/update",
            data: {
                id: id,
                qty: value
            },
            dataType: "JSON",
            success: function(res) {
                var total_cost = 0;
                var qty = 0;
                var promo = 0;
                let qty_carticon = 0
                res.details.forEach(function(cd) {
                    if ($("#check" + cd.id).prop('checked')) {
                        total_cost += parseInt(cd.price);
                        qty += parseInt(cd.qty);
                        promo += parseInt(cd.promo);
                    }
                    qty_carticon += parseInt(cd.qty)
                    if (cd.id == id) {
                        $("#subtotal" + cd.id).html((cd.price - cd.promo).toLocaleString("id-ID", myObj));
                    }
                })
                $('#cart_qty').text(parseInt(qty_carticon));
                $("#total_cost").html(parseInt(total_cost).toLocaleString("id-ID", myObj));
                $("#promo").html(parseInt(promo).toLocaleString("id-ID", myObj));
                $("#total").html(parseInt(total_cost - promo).toLocaleString("id-ID", myObj));
                $("#qty").html(parseInt(qty));
            },
            error: function(xhr, status, err) {
                console.log(err);
            }
        })
    }


   
    $("#select-all").click(function() {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        count_selected_cart();
    });

    $('.cb-item-cart').change(function(){
        count_selected_cart();
    });

    $('.btn-increment').click(function(){
        let input = $(this).closest('.div-qty').find('.input-qty');
        let qty = parseInt($(input).val()) + 1;
        $(input).val(qty);
        $(input).change();
    })

    $('.btn-decrement').click(function(){
        let input = $(this).closest('.div-qty').find('.input-qty');
        let qty = parseInt($(input).val()) - 1;
        $(input).val(qty);
        $(input).change();
    })

    $('.input-qty').change(function(){
        update($(this).data('id'), $(this).val());
    });

    function count_selected_cart(){
        let total_cb_item = $('.cb-item-cart').length;
        let count_checked = 0;
        let total_cost = 0;
        let promo = 0;
        let total_qty = 0;
        $('.cb-item-cart').each(function () {
            if ($(this).prop('checked')) {
                count_checked++;
                let input = $(this).closest('.card-item-cart').find('.input-qty');
                total_qty += parseInt($(input).val());
                let sub_total = parseInt($(this).data('price')) * parseInt($(input).val());
                total_cost += sub_total;
                promo += parseInt($(this).attr('data-promo'))
            }
        });
        console.log("prmoo" + promo);

        if(count_checked > 0 ){
            if (count_checked == total_cb_item) {
                $('#select-all').prop('checked', true);
            }else{
                $('#select-all').prop('checked', false);
            }
        }else{
            $('#select-all').prop('checked', false);
        }

        $("#total_cost").html(total_cost.toLocaleString("id-ID", myObj));
        $("#qty").html(total_qty);
        $("#promo").html(promo.toLocaleString("id-ID", myObj));
        $("#total").html((total_cost - promo).toLocaleString("id-ID", myObj));
    }

    $('.delete-cart').click(function () {
        let name = $(this).data('product-name');
        sweet_alert("warning", name, "Apakah Anda Yakin ?", true).then((result) => {
            if (result.isConfirmed) {
                window.location.href = $(this).data('url-delete');
            } else if (result.isDismissed) {
                return false;
            }
        })
    })

    function deleteAll() {
        let array_selected = [];

        $('.cb-item-cart').each(function () {
            if ($(this).prop('checked')) {
                array_selected.push($(this).val());
            }
        })
        console.log(array_selected);
        if (array_selected.length == 0) {
            sweet_alert("warning", "Tidak Ada Item yang Terpilih", "Silahkan Pilih Item Yang ingin dihapus").then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            })
        }else{
            sweet_alert("warning", "Hapus Beberapa Item", "Apakah Anda Yakin Menghapus Item Yang Terpilih?", true).then((result) => {
                if (result.value) {
                    submit_delete_multi_cart(array_selected);
                }
            })
        }
    }

    function submit_delete_multi_cart(array_selected) {
        $('#item-cart').val(array_selected);
        $('#form-item-cart').submit();
    }



    $("#continue").on('click', function(e) {
        e.preventDefault();
        if ($("#checkout-form input[type=checkbox]:checked").length == 0) {
            sweet_alert("error", "Tidak bisa lanjut", "Pastikan produk yang ingin dibeli sudah tercentang ").then(function(e) {
                e.dismiss;
            }, function(dismiss) {
                return false;
            })
        } else {
            $("#checkout-form").submit();
        }
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection