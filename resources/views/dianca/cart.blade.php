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
                                <div class="form-inline">
                                    <input class="form-check-input primary-checkbox" type="checkbox" value="" id="select-all">
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
                                <div class="form-check text-gray-2 my-4">
                                    <input class="form-check-input position-static align-top primary-checkbox cb-item-cart" type="checkbox" name="cd[]" id="check{{ $cd->id }}" value="{{ $cd->id }}" onclick="selectCart({{ $cd->id }})">
                                    <div class="card cart-card shadow-1 w-90">
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
                                <p>Total Harga<strong><span class="float-right" id="total_cost">Rp {{ number_format(0, 2, ',', '.') }}</span></strong></p>
                                <button type="button" id="continue" class="btn btn-orange weight-600 btn-block font-18 py-2">Beli Sekarang (<span id="qty">{{ 0 }}</span>)</a>
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
        console.log("adssad");
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
                let qty_carticon = 0
                res.details.forEach(function(cd) {
                    if($("#check"+cd.id).prop('checked')){
                        total_cost += parseInt(cd.price);
                        qty += parseInt(cd.qty);
                    }
                    qty_carticon += parseInt(cd.qty)

                    if(cd.id == id) {
                        $("#subtotal"+cd.id).html(cd.price.toLocaleString("id-ID", myObj));
                    }
                })
                $('#qty-cart-icon').text(parseInt(qty_carticon));
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
        let total_cb_item = $('.cb-item-cart').length;
        let count_checked = 0;

        $('.cb-item-cart').each(function () {
            if ($(this).prop('checked')) {
                count_checked++;
            }
        })

        if (count_checked == total_cb_item) {
            $('#select-all').prop('checked', true);
        }else{
            $('#select-all').prop('checked', false);
        }
        // console.log($('.cb-item-cart').length);

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

    $('.delete-cart').click(function () {
        let id = $(this).data('id');
        let name = $(this).data('product-name');
        swal({
            title: name,
            text: "Apakah Anda Yakin ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
                // console.log("asd", result);
            if (result.value) {
                window.location.href = $(this).data('url-delete');
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
        if (array_selected.length == 0) {
            swal({
                title: "Tidak Ada Item yang Terpilih",
                text: "Silahkan Pilih Item Yang ingin dihapus",
                type: "warning",
                reverseButtons: !0
            }).then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            });
        }else{
            swal({
                title: 'Hapus Beberapa Item',
                text: "Apakah Anda Yakin Menghapus Item Yang Terpilih?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                    // console.log("asd", result);
                if (result.value) {
                    submit_delete_multi_cart(array_selected);
                    // window.location.href = $(this).data('url-delete');
                }
            })
        }
        // console.log(array_selected)
    }

    function submit_delete_multi_cart(array_selected) {
        $('#item-cart').val(array_selected);
        $('#form-item-cart').submit();
    }

    function removeFromCart(id) {

    }

    $("#continue").on('click', function(e) {
        e.preventDefault();
        if($("#checkout-form input[type=checkbox]:checked").length == 0) {
            swal({
                title: "Tidak bisa lanjut",
                text: "Pastikan produk yang ingin dibeli sudah tercentang ",
                type: "error",
                reverseButtons: !0
            }).then(function (e) {
                e.dismiss;
            }, function (dismiss) {
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