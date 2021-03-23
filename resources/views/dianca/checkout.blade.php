@extends('layouts.store')

@section('title')
<title>Pembelian</title>
@endsection

@section('content')
<section class="feature_product_area section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container">
            <div class="row my-2">
                <div class="main_title">
                    <h2 class="pl-3">Pembayaran</h2>
                    <h5 class="pl-3 pt-2">1 dari 2 langkah</h5>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-4">
                    <hr class="rounded" style="border: 5px solid orange">
                    <h6 style="color: black">1 Checkout</h6>
                </div>
                <div class="col-lg-4">
                    <hr class="rounded" style="border: 5px solid gray">
                    <h6 style="color: gray">2 Bayar</h6>
                </div>
                <hr class="pb-2" style="border-color:F2F2F2">
            </div>
            <form action="{{ route('checkout.payment') }}" method="POST" id="checkout-form">
                @csrf
                <div class="row my-2">
                    <div class="main_title text-gray-2">
                        <h3 class="pl-3">Alamat Pengiriman</h3>
                    </div>
                </div>

                <div class="row my-2 pb-3" id="noAddress">
                    <div class="col">
                        <a type="button" class="btn btn-outline-orange" href="" aria-disabled="true" data-toggle="modal" id="btn-add-address" data-url-add = "{{ route('profile-address.add') }}">Buat Alamat Baru</a>
                    </div>
                </div>

                @if (auth()->guard('customer')->user()->address != 0)
                <div id="hasAddress">
                    <div class="row my-2 pl-3">
                        <h5 id="receiver_name_main"><strong>{{ $address->receiver_name }}</strong>
                            ({{ $address->address_type }})</h5>
                    </div>
                    <div class="row my-2 pl-3" style="color: #333333">
                        <h5 id="receiver_phone_main">{{ $address->receiver_phone }}</h5>
                    </div>
                    <div class="row my-2 pb-3 pl-3" style="color: #333333">
                        <h5 id="receiver_address_main">{{ $address->address }}</h5>
                        <h5 id="receiver_city_main">, {{ $address->district->city->type }} {{ $address->district->city->name }}</h5>
                        <h5 id="receiver_postal_main">, {{ $address->postal_code }}</h5>
                    </div>
                    <div class="row my-2 pl-3">
                        <button type="button" class="btn btn-outline-orange" href="" id="btn-pilih-alamat" data-url="{{ route('checkout.list-address') }}">Pilih Alamat</button>
                    </div>
                </div>
                @endif
                <input type="hidden" value="{{ (auth()->guard('customer')->user()->address != 0) ? $address->id : '' }}" name="address_id" id="address_id">
                <hr class="pb-2" style="border-color:F2F2F2">
                <div class="row pt-2 pl-2">
                    <div class="col-lg-8">
                        <div class="row py-2">
                            <div class="col-lg-12 pb-1">
                                @if(auth()->guard('customer')->check())
                                @foreach ($cart_detail as $val)
                                <div class="card shadow-1 mb-3" style="width: 47rem">
                                    <div class="row px-4 py-4">
                                        <div class="col-lg-3">
                                            <a href="#">
                                                <img id="image" class="product-img-sm"
                                                    src="{{ asset('storage/products/' . $val->variant->product->images->first()->filename) }}"
                                                    alt="Starterkit">
                                            </a>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row ml-2 pt-3">
                                                <a href="#">
                                                    <h4 class="text-gray-2 weight-600 font-24">
                                                        {{ $val->variant->product->name }}</h4>
                                                </a>
                                            </div>
                                            <div class="row ml-2 pt-2">
                                                <h5>{{ $val->qty }} Barang</h5>
                                                <h5>({{ $val->variant->weight }} gr)</h5>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ $val->id }}" name="cd[]">
                                    </div>
                                    <div class="container">
                                        <hr class="" style="border-color:F2F2F2">
                                    </div>
                                    <div class="row px-4 py-2" style="height: 60px">
                                        <div class="col-lg-9">
                                            <h5 class="ml-2">Sub Total Harga: <strong>Rp
                                                    {{ number_format($val['price'], 2, ',', '.') }}</strong></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <!-- <div id="edit-btn">
                                                <a type="button" class="btn btn-outline-orange float-right"
                                                    aria-disabled="true" href="{{ route('cart.show') }}">Edit</a>
                                            </div> -->
                                            <div id="edit-qty" style="display: none;">
                                                <div class="btn-group btn-group-vertical-center float-right">
                                                    <span class="product_count">
                                                        <button class="reduced items-count font-10" type="button"
                                                            onclick="decrement({{ $val->id }})">
                                                            <span class="material-icons md-10">remove</span>
                                                        </button>
                                                    </span>
                                                    <span class="product_count">
                                                        <input type="text" name="qty[]" id="qty{{ $val->id }}"
                                                            maxlength="3" value="{{ $val->qty }}"
                                                            style="height:26px;width:70px" class="input-text" required>
                                                    </span>
                                                    <span class="product_count">
                                                        <button class="increase items-count font-10" type="button"
                                                            onclick="increment({{ $val->id }})">
                                                            <span class="material-icons md-10">add</span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <hr class="" style="border-color:F2F2F2">
                        <div class="row py-2 ml-2 pb-4">
                            <div class="col-lg-6" style="color: #4F4F4F">
                                <div class="main_title pb-2">
                                    <h4>Pengiriman</h4>
                                </div>
                                <div class="form-group">
                                    <label>Pilih Jasa Pengiriman</label><br>
                                    <select id="courier" name="courier" class="form-control border border-secondary"
                                        style="width:8rem">
                                        <option value="" selected>Pilih</option>
                                        <option value="JNT">JNT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pilih Durasi</label><br>
                                    <select id="duration" name="duration" class="form-control border border-secondary"
                                        style="width:12rem">
                                        <option value="" selected>Pilih</option>
                                        <option value="regular">Regular (4-5 hari)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="main_title pb-2 ml-2">
                                    <h4 style="color: #4F4F4F">Ringkasan Pengiriman</h4>
                                </div>
                                <div class="row px-4 py-2" style="color: #828282">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <h6>Jasa Pengiriman</h6>
                                        </div>
                                        <div class="row pt-1">
                                            <h6>Durasi</h6>
                                        </div>
                                        <div class="row pt-1">
                                            <h6>Estimasi Tiba</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <h6>JNT (Regular)</h6>
                                        </div>
                                        <div class="row pt-1">
                                            <h6>4 - 5 hari</h6>
                                        </div>
                                        <div class="row pt-1">
                                            <h6>24 - 25 Desember 2020</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <div class="card shadow-1">
                            <div class="card-body font-18">
                                <h4 style="color: #828282"><strong>Ringkasan Belanja</strong></h4>
                                <hr>
                                <div class="row py-2">
                                    <div class="col-lg-6" style="color: #828282">
                                        <h5>Total Harga</h5>
                                        <h5>Ongkos Kirim</h5>
                                        <h5>Total Tagihan</h5>
                                    </div>
                                    <div class="col-lg-6 float-right" style="text-align: right">
                                        <h5>Rp {{ number_format($total_cost) }}</h5>
                                        <h5 id="ongkir">Rp 17,000</h5>
                                        <input type="hidden" value="17000" name="shipping_cost">
                                        <input type="hidden" value="{{ $total_cost }}" name="subtotal">
                                        <h5 id="total"><strong>Rp {{ number_format($total_cost + 17000) }}</strong></h5>
                                    </div>
                                </div>
                                <button type="button" id="continue" class="btn btn-orange weight-600 btn-block font-18 py-2" id="payment">Pilih Pembayaran</button>
                                <a type="button" href="{{ route('cart.show') }}" class="btn btn-outline-orange weight-600 btn-block font-18 py-2" id="payment">Ubah Pembelian</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<div class="modal fade w-100" id="modal-form-address" role="dialog" data-is-edit=false>
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute" id="title-modal-form">Buat Alamat Baru</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="cart_inner">
                        <form id="form-address" method="POST">
                            @csrf
                            <div class="form-row pl-2 pr-2 pb-3">
                                <div class="form-group col-md-10">
                                    <label>Jenis Alamat</label><br>
                                    <input type="text" name="address_type" id="address_type" class="form-control"
                                        style="background: #F6F6F6" required>
                                    <p class="text ml-1" style="color: #828282">Contoh : Alamat Kantor, Alamat Rumah,
                                        Apartemen</p>
                                    <input type="hidden" value="{{ auth()->guard('customer')->user()->id }}" id="customer_id" name="customer_id">
                                </div>
                                <div class="col-md-2 form-check">
                                    <label class="form-check-label" for="is_main">
                                        Alamat utama?
                                    </label>
                                    <input class="form-check-input" type="checkbox" value="" id="is_main" name="is_main">
                                </div>
                            </div>
                            <div class="form-row pl-2 pr-2 pb-3">
                                <div class="form-group col-md-6">
                                    <label>Nama Penerima</label>
                                    <input type="text" class="form-control" id="receiver_name" name="receiver_name"
                                        style="background: #F6F6F6" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nomor Telepon</label>
                                    <input type="text" class="form-control" id="receiver_phone" name="receiver_phone"
                                        style="background: #F6F6F6" required>
                                    <p class="text ml-1" style="color: #828282">Contoh : 081234567890</p>
                                </div>
                            </div>
                            <div class="form-row pl-2 pr-2 pb-3">
                                <div class="form-group col-md-6">
                                    <label>Provinsi</label>
                                    <select id="province_id" name="province_id" class="form-control bg-light-2">
                                        <option value="" selected>Pilih</option>
                                        @foreach($provinces as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kota/Kabupaten</label>
                                    <select id="city_id" name="city_id" class="form-control bg-light-2">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row pl-2 pr-2 pb-3">
                                <div class="form-group col-md-8">
                                    <label>Kecamatan</label>
                                    <select id="district_id" name="district_id" class="form-control bg-light-2">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Kode Pos</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                                        style="background: #F6F6F6" required>
                                </div>
                            </div>
                            <div class="form-group pl-2 pr-2 pb-3">
                                <label>Alamat</label><br>
                                <textarea name="address" id="address" cols="60" rows="4" class="form-control"
                                    style="background: #F6F6F6; border: none" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="row float-right">
                        <div class="col-md-12">
                            <div class="cart-inner">
                                <div class="out_button_area">
                                    <div class="checkout_btn_inner">
                                        <a id="close-add-address" class="btn btn-outline-gray" data-dismiss="modal">Batal</a>
                                        <a type="submit" class="btn btn-orange weight-600" id="add-address">Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade w-100"  role="dialog" id="modal-list-alamat">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute">Daftar Alamat</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="cart_inner" id="div-list-alamat">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade w-100"  role="dialog" id="modal-edit-alamat">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute">Daftar Alamat</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="cart_inner" id="div-list-alamat">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var province_id;
    var city_id;
    var district_id;
    $("#province_id").on('change', function() {
        let isSelected = '';
        $.ajax({
            url: "{{ route('cities') }}",
            type: 'GET',
            data: {
                province_id: $(this).val()
            },
            dataType: "JSON",
            success: function(res) {
                $("#city_id").empty();
                $.each(res, function(key, item) {
                    isSelected = ''
                    if (item.id == city_id) {
                        isSelected = 'selected';
                    }
                    $("#city_id").append('<option value="' + item.id + '" '+isSelected+'>' + item
                        .type + " " + item.name + '</option>');
                });
                if (city_id != '' || city_id != undefined) {
                    $("#city_id").change()
                }
            },
        });
    });
    $("#city_id").on('change', function() {
        let isSelected = '';
        $.ajax({
            url: "{{ route('districts') }}",
            type: 'GET',
            data: {
                city_id: $(this).val()
            },
            dataType: "JSON",
            success: function(res) {
                $("#district_id").empty();
                $.each(res, function(key, item) {
                    isSelected = ''
                    if (item.id == city_id) {
                        isSelected = 'selected';
                    }
                    $("#district_id").append('<option value="' + item.id + '">' +
                        item.name + '</option>');
                });
            },
        });
    });

    @if(auth()->guard('customer')->user()->address != 0)
        @if($address->is_main)
            $("#is_main").prop('checked', true);
            $("#is_main").val(1);
        @endif
        $('#province_id>option[value="' + {{ $address->district->city->province->id }} + '"]').prop('selected', true);
        $('#province_id').val({{ $address->district->city->province->id }}).change();
    @endif
    
    $("#add-address").on("click", function(e) {
        $('#form-address').submit();
    });

    $('#btn-pilih-alamat').click(function () {
        $.ajax({
            type: "GET",
            url: $(this).data('url'),
            // data: ,
            // dataType: "JSON",
            success: function(res) {
                // console.log(res);
                // $('')
                $('#div-list-alamat').html(res);
                $('#modal-list-alamat').modal('toggle');
                $('#modal-list-alamat').modal('show');
            },
            error: function(xhr, status, err) {
                console.log(err);
            }
        });
    })

   $(document).on('click', '.delete-address', function () {
        // swal({
        //     title: 'Hapus Alamat',
        //     text: "Apakah Anda Yakin Menghapus Alamat "+ $(this).data('address-type'),
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Ya',
        //     cancelButtonText: 'Tidak'
        // }).then((result) => {
        //         // console.log("asd", result);
        //     if (result.value) {
        //         window.location.href = $(this).data('url-delete');
        //     }
        // })

        sweet_alert("warning", "Hapus Alamat", "Apakah Anda Yakin Menghapus Alamat "+ $(this).data('address-type'), true).then((result) => {
                // console.log("asd", result);
            if (result.value) {
                window.location.href = $(this).data('url-delete');
            }
        })
    })

   $(document).on('click', '.update-alamat', function () {
        reset_form();
        $('#modal-list-alamat').data('to-open-form', true)
        get_detail_address($(this).data("url-detail"), $(this).data("id"), $(this).data('url-edit'))
        
   });


   $('#btn-add-address').click(function () {
        reset_form();
        $('#form-address').attr('action', $(this).data('url-add'));
        $('#title-modal-form').text('Buat Alamat Baru');
        open_modal_form(false)

   })

   $('#modal-form-address').on('hidden.bs.modal', function () {
        if ($(this).data('is-edit')) {
            $('#modal-list-alamat').modal('toggle');
            $('#modal-list-alamat').modal('show');
        }
    });

   $('#modal-list-alamat').on('hidden.bs.modal', function () {
        if ($(this).data('to-open-form')) {
            open_modal_form(true)
        }
    });

   $('#modal-list-alamat').on('shown.bs.modal', function () {
        $(this).data('to-open-form', false)
    });
   
    
    $("#continue").on('click', function(e) {
        e.preventDefault();
        if($("#courier").val() == "" || $("#duration").val() == ""){
            // Swal.fire({
            //     title: "Detail Tidak Lengkap",
            //     text: "Pilih jasa pengiriman dan durasi pengiriman",
            //     icon: "warning",
            //     reverseButtons: !0
            // }).then(function (e) {
            //     e.dismiss;
            // }, function (dismiss) {
            //     return false;
            // });

            sweet_alert("warning", "Detail Tidak Lengkap", "Pilih jasa pengiriman dan durasi pengiriman").then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            })
            return false;
        }
        if ($('#address_id').val() == '') {
            sweet_alert("warning", "Detail Tidak Lengkap", "Alamat Masih Kososng").then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            })
            return false;
        }
        $("#checkout-form").submit();
    })
})

async function get_detail_address(url, id, url_form) {
    await $.ajax({
        url: url,
        type: 'GET',
        data: {
            id: id
        },
        dataType: "JSON",
        success: function(res) {
            if (res.status) {
                province_id = res.data.province_id;
                city_id = res.data.city_id;
                district_id = res.data.district_id;

                if (res.data.is_main == 1) {
                   $('#is_main').prop( "checked", true ); 
                }else{
                    $('#is_main').prop( "checked", false ); 
                }
                $('#address_type').val(res.data.address_type);
                $('#receiver_name').val(res.data.receiver_name);
                $('#receiver_phone').val(res.data.receiver_phone)
                $('#province_id').val(res.data.province_id).change();
                $('#form-address').attr('action', url_form);
                $('#postal_code').val(res.data.postal_code);
                $('#address').val(res.data.address);
                $('#title-modal-form').text('Ubah Alamat');
            }
        },
    });
    $('#modal-list-alamat').modal('toggle');
    await $('#modal-list-alamat').modal('hide');
}

function open_modal_form(is_edit) {
    $('#modal-form-address').data('is-edit', is_edit);
    $('#modal-form-address').modal('toggle');
    $('#modal-form-address').modal('show');
}

function reset_form() {
    province_id = '';
    city_id = '';
    district_id = '';
    document.getElementById("form-address").reset();
    $("#city_id").empty();
    $("#district_id").empty();
    $("#city_id").append('<option value="" >Pilih</option>');
    $("#district_id").append('<option value="" >Pilih</option>');
}

</script>
@endsection