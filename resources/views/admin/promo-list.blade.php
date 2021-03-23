@extends('layouts.admin')

@section('title')
<title>Promo</title>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-lg-12">
            @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            <div class="table-responsive curved-border">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="btn-group py-4">
                            <ul class="filter-buttons">
                                <li>
                                    <a href="{{ route('administrator.promo', 'all') }}" type="button"
                                        class="btn btn-filter px-5 mx-5 " id="all-promos">Semua Promo</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.promo', 'flash') }}" type="button"
                                        class="btn btn-filter px-5 mx-5 " id="flash-promos">Flash Sale</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.promo', 'event') }}" type="button"
                                        class="btn btn-filter px-5 mx-5 " id="event-promos">Event Promo</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.promo', 'single') }}" type="button"
                                        class="btn btn-filter px-5 mx-5 " id="single-promos">Promo Item</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered text-gray-2">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-1">No</th>
                            <th class="col-3">Waktu Mulai</th>
                            <th class="col-3">Waktu Selesai</th>
                            <th class="col-1">Jumlah Produk</th>
                            <th class="col-2">Status</th>
                            <th class="col-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promos as $row)
                        <tr class="d-flex">
                            <td class="col-1" id="number">{{ $loop->iteration }}</td>
                            <td class="col-3">{{ $row->start_date }} - {{ $row->start_time }} WIB</td>
                            <td class="col-3">{{ $row->end_date }} - {{ $row->end_time }} WIB</td>
                            <td class="col-1">{{ $row->details->count() }}</td>
                            <td class="col-2">
                                @if($row->is_published == 0)
                                <span class="badge badge-light">Belum Publish</span>
                                @else
                                {!! $row->status_label !!}
                                @endif
                            </td>
                            <td class="col-2">
                                <button class="btn btn-outline-orange dropdown-toggle" data-toggle="dropdown"
                                    role="button">Aksi</button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item" data-toggle="modal" data-target="#show-promo"
                                        value="{{ $row->id }}">Detail</button>
                                    <button class="dropdown-item" data-toggle="modal" data-target="#update-promo"
                                        value="{{ $row->id }}">Ubah</button>
                                    <form action="{{ route('administrator.promo.publish', ['id' => $row->id]) }}"
                                        method="post">
                                        @csrf
                                        <button class="dropdown-item"
                                            onclick="return confirm('Publish Promo?')">Publish</button>
                                    </form>
                                    <form action="{{ route('administrator.promo.delete', ['id' => $row->id]) }}"
                                        method="post">
                                        @csrf
                                        <button class="dropdown-item"
                                            onclick="return confirm('Hapus Promo?')">Hapus/Batalkan</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12">Belum ada promo.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="d-flex">
                            <td class="col-12">
                                <button class="btn btn-orange float-right" data-toggle="modal" data-target="#add-promo">
                                    <span><i class="material-icons md-18">add</i></span>Tambah Promo
                                    </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="float-right mt-4">
                {!! $promos->links('pagination::default') !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="add-promo" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute">Tambah Promo</h3>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{ route('administrator.promo.create') }}" method="POST">
                        @csrf
                        <div class="form-group px-2">
                            <label for="type">Jenis Promo</label>
                            <select class="form-control border-3" name="type" id="type">
                                <option value="">Pilih</option>
                                <option value="single">Promo Item</option>
                                <option value="event">Promo Event</option>
                                <option value="flash">Flash Sale</option>
                            </select>
                        </div>
                        <div class="form-group px-2">
                            <label for="name">Nama Promo</label>
                            <input type="text" id="name" name="name" class="form-control border-3">
                        </div>
                        <div class="form-group px-2">
                            <label for="payment_duration">Batas Waktu Pembayaran Setelah Checkout</label>
                            <div class="input-group">
                                <input type="text" name="payment_duration" class="form-control border-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-3 border">menit</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-row px-2 justify-content-between">
                            <div class="col-md-6">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="text" id="start_date" name="start_date" class="form-control border-3">
                            </div>
                            <div class="col-md-6">
                                <label for="start_time">Jam Mulai</label>
                                <input type="text" id="start_time" name="start_time" class="form-control border-3">
                            </div>
                        </div>
                        <div class="form-group form-row px-2">
                            <div class="col-md-6">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="text" id="end_date" name="end_date" class="form-control border-3">
                            </div>
                            <div class="col-md-6">
                                <label for="end_time">Jam Selesai</label>
                                <input type="text" id="end_time" name="end_time" class="form-control border-3">
                            </div>
                        </div>
                        <div class="form-group px-2">
                            <label for="value_type">Jenis Diskon</label>
                            <select class="form-control border-3 sign_type" name="value_type" id="value_type">
                                <option value="percent" selected>Persentase</option>
                                <option value="price">Harga</option>
                            </select>
                        </div>
                        <div class="form-group px-2">
                            <label for="value">Promo</label>
                            <div class="input-group">
                                <input type="text" name="value" id="value" class="form-control border-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-3 border sign">%</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group px-2">
                            <label for="product-select">Pilih Varian</label>
                            <select id="product-select" name="product_variant[]" class="form-control border-3 w-100"
                                multiple="multiple">
                                @forelse($products as $row)
                                <optgroup label="{{ $row->name }}">
                                    @forelse($row->variant as $subrow)
                                    <option value="{{ $subrow->id }}">{{ $row->name }} - {{ $subrow->name }}</option>
                                    @empty
                                    @endforelse
                                </optgroup>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group px-2 text-center">
                            <button class="btn btn-orange">Tambah Promo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="show-promo" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute">Detail Promo</h3>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <h5 class="weight-600">Nama Promo</h5>
                            <h6 id="modal-name"></h6>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="weight-600">Jenis Promo</h5>
                            <h6 id="modal-promo-type"></h6>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4">
                            <h5 class="weight-600">Mulai</h5>
                            <h6 id="modal-start"></h6>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="weight-600">Berakhir</h5>
                            <h6 id="modal-end"></h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-lg-4">
                            <h5 class="weight-600">Besar Promo</h5>
                            <h5 id="modal-value"></h5>
                        </div>
                        <div class="col-lg-8">
                            <h5 class="weight-600">Batas Waktu Bayar Setelah Checkout</h5>
                            <h6 id="modal-payment-duration"></h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <h5 class="weight-600">Daftar Varian</h5>
                            <div id="variant-list">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="update-promo" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute">Update Promo</h3>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{ route('administrator.promo.update') }}" method="POST">
                        @csrf
                        <div class="form-group px-2">
                            <label for="input_type">Jenis Promo</label>
                            <select class="form-control border-3" name="type" id="input_type">
                                <option value="">Pilih</option>
                                <option value="single">Promo Item</option>
                                <option value="event">Promo Event</option>
                                <option value="flash">Flash Sale</option>
                            </select>
                        </div>
                        <div class="form-group px-2">
                            <label for="input_name">Nama Promo</label>
                            <input type="text" id="input_name" name="name" class="form-control border-3">
                        </div>
                        <div class="form-group px-2">
                            <label for="input_payment_duration">Batas Waktu Pembayaran Setelah Checkout</label>
                            <div class="input-group">
                                <input type="text" id="input_payment_duration" name="payment_duration"
                                    class="form-control border-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-3 border">menit</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-row px-2 justify-content-between">
                            <div class="col-md-6">
                                <label for="input_start_date">Tanggal Mulai</label>
                                <input type="text" id="input_start_date" name="start_date"
                                    class="form-control border-3">
                            </div>
                            <div class="col-md-6">
                                <label for="input_start_time">Jam Mulai</label>
                                <input type="text" id="input_start_time" name="start_time"
                                    class="form-control border-3">
                            </div>
                        </div>
                        <div class="form-group form-row px-2">
                            <div class="col-md-6">
                                <label for="input_end_date">Tanggal Selesai</label>
                                <input type="text" id="input_end_date" name="end_date" class="form-control border-3">
                            </div>
                            <div class="col-md-6">
                                <label for="input_end_time">Jam Selesai</label>
                                <input type="text" id="input_end_time" name="end_time" class="form-control border-3">
                            </div>
                        </div>
                        <div class="form-group px-2">
                            <label for="input_value_type">Jenis Diskon</label>
                            <select class="form-control border-3 sign_type" name="value_type" id="input_value_type">
                                <option value="percent" selected>Persentase</option>
                                <option value="price">Harga</option>
                            </select>
                        </div>
                        <div class="form-group px-2">
                            <label for="input_value">Promo</label>
                            <div class="input-group">
                                <input type="text" name="value" id="input_value" class="form-control border-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-3 border sign">%</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group px-2">
                            <label for="input-product-select">Pilih Varian</label>
                            <select id="input-product-select" name="product_variant[]"
                                class="form-control border-3 w-100" multiple="multiple">
                                @forelse($products as $row)
                                <optgroup label="{{ $row->name }}">
                                    @forelse($row->variant as $subrow)
                                    <option value="{{ $subrow->id }}">{{ $row->name }} - {{ $subrow->name }}</option>
                                    @empty
                                    @endforelse
                                </optgroup>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group px-2 text-center">
                            <button class="btn btn-outline-gray">Batal</button>
                            <button class="btn btn-orange">Update Promo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    if (window.location.href.indexOf("/all") > -1) {
        $("#all-promos").addClass('filter-active-2');
    } else if (window.location.href.indexOf("/flash") > -1) {
        $("#flash-promos").addClass('filter-active-2');
    } else if (window.location.href.indexOf("/event") > -1) {
        $("#event-promos").addClass('filter-active-2');
    } else if (window.location.href.indexOf("/single") > -1) {
        $("#single-promos").addClass('filter-active-2');
    }
});

$("#product-select").select2({
    width: '100%',
});
$("#input-product-select").select2({
    width: '100%',
});

$(function() {
    $('#start_date').daterangepicker({
        startDate: moment(),
        singleDatePicker: true,
        showDropdowns: true,
        maxYear: parseInt(moment().format('YYYY'), 10),
        autoUpdateInput: true,
        linkedCalendars: true,
    });

    $('#end_date').daterangepicker({
        startDate: moment(),
        singleDatePicker: true,
        showDropdowns: true,
        maxYear: parseInt(moment().format('YYYY'), 10),
        autoUpdateInput: true,
    });

    $('#start_time').daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        timePickerSeconds: true,
        locale: {
            format: 'HH:mm:ss'
        }
    }).on('show.daterangepicker', function(e, picker) {
        picker.container.find('.calendar-table').hide();
    });

    $('#end_time').daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        timePickerSeconds: true,
        locale: {
            format: 'HH:mm:ss'
        }
    }).on('show.daterangepicker', function(e, picker) {
        picker.container.find('.calendar-table').hide();
    })
});

$("#show-promo").on('show.bs.modal', function(e) {
    var promo_id = $(e.relatedTarget).val();
    console.log(promo_id);
    $.ajax({
        url: '/admin/promos/detail/' + promo_id,
        type: 'GET',
        data: {
            id: parseInt(promo_id)
        },
        dataType: 'JSON',
        success: function(res) {
            console.log(res);
            $("#modal-name").html(res.name);

            if (res.promo_type == 'flash')
                $("#modal-promo-type").html("PROMO FLASH");
            else if (res.promo_type == 'event')
                $("#modal-promo-type").html("PROMO EVENT");
            else if (res.promo_type == 'single')
                $("#modal-promo-type").html("PROMO ITEM");

            var startdate = new Date(res.start_date);
            var enddate = new Date(res.end_date);
            $("#modal-start").html(startdate.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) + " " + res.start_time + " WIB");
            $("#modal-end").html(enddate.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) + " " + res.end_time + " WIB")

            if (res.value_type == 'percent') {
                var symbol = "%";
                $("#modal-value").html("<strong><b>" + symbol + "</b> " + res.value + "</strong>");
            } else {
                var symbol = "Rp";
                $("#modal-value").html("<strong><b>" + symbol + "</b> " + res.value.toLocaleString(
                    "id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }) + "</strong>");
            }

            $("#modal-payment-duration").html(res.payment_duration + " menit");


            if (res.details != "") {
                for (var i in res.details) {
                    if (res.value_type == 'percent') {
                        var value_amount = res.details[i].variant.price - ((res.value / 100) * res
                            .details[i].variant.price);
                    } else {
                        var value_amount = res.details[i].variant.price - res.value;
                    }

                    var detail = $(`
                    <div class="card border-3 my-2">
                        <div class="card-body">
                            <div class="media">
                                <div class="row d-flex">
                                    <img class="mr-2" src="{{ asset('storage/products/` + res.details[i].variant
                        .product.images[0].filename + `') }}" width="100px" height="100px">
                                    <div class="media-body">
                                        <h6>` + res.details[i].variant.product.name +
                        `<span class="ml-4"><small>Varian ` + res.details[i].variant.name + `</small></span></h6>
                                        <h6>Harga Awal ` + res.details[i].variant.price.toLocaleString("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }) + `</h6>
                                        <h6><strong>Harga Setelah Diskon ` + value_amount.toLocaleString("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }) + `</strong></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `)
                    $("#variant-list").append(detail);
                }
            }
        },
        error: function(xhr, status, err) {
            console.log(xhr.responseText);
        }
    })
});

$("#show-promo").on('show.bs.modal', function(e) {
    $("#variant-list div").remove();
})

$("#update-promo").on('show.bs.modal', function(e) {
    var promo_id = $(e.relatedTarget).val();
    $.ajax({
        url: '/admin/promos/change/' + promo_id,
        type: 'GET',
        data: {
            promo_id: parseInt(promo_id)
        },
        dataType: 'JSON',
        success: function(res) {
            $("#input_type").val(res.promo_type);
            $("#input_name").val(res.name);
            $("#input_payment_duration").val(res.payment_duration);
            $("#input_start_date").val(res.start_date);
            $("#input_start_time").val(res.start_time);
            $("#input_end_date").val(res.end_date);
            $("#input_end_time").val(res.end_time);
            $('#input_value_type>option[value="' + res.value_type + '"]').prop('selected', true);
            if(res.value_type == 'price')
                $(".sign").html('Rp');
            $("#input_value").val(res.value);

            var items = [];
            for (var i in res.details) {
                items.push(res.details[i].variant.id);
            }

            $("#input-product-select").val(items).change();
            
        },
        error: function(xhr, status, err) {
            console.log(xhr.responseText);
        },
    })
});

$('.sign_type').on('change', function() {
    if($(this).val() == 'price')
        $('.sign').html("Rp");
    else
        $('.sign').html("%");
})

$('.pagination li').addClass('page-item');
$('.pagination li a').addClass('page-link');
$('.pagination span').addClass('page-link');
</script>
@endsection