@extends('layouts.store')

@section('title')
    <title>Pembelian</title>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            @if (session('error'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="row my-2">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2 class="pl-3">Pembelian</h2>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-12">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <div class="row mx-2">
                                <div class="col-lg-2 px-2">
                                    <p>Lihat Transaksi: </p>
                                </div>
                                <div class="col-lg-4 px-2">
                                    <div class="form-group">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" name="begin_date" id="begin" />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="material-icons md-18">calendar_today</i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 px-2">
                                    <div class="form-group">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" name="end_date" id="end"/>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="material-icons md-18">calendar_today</i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-2 my-2">
                                <div class="col-lg-12 px-2">
                                    <h4 class="weight-600">Filter Status</h4>
                                    <ul class="filter-buttons">
                                        <li>
                                            <a href="{{ route('transaction.list', 5) }}" type="button" class="btn btn-filter" id="all-orders">Semua</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transaction.list', 0) }}" type="button" class="btn btn-filter" id="pending-orders">Menunggu Pembayaran</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transaction.list', 1) }}" type="button" class="btn btn-filter" id="processing-orders">Pesanan Diproses</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transaction.list', 2) }}" type="button" class="btn btn-filter" id="sent-orders">Pesanan Dikirim</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transaction.list', 3) }}" type="button" class="btn btn-filter" id="finished-orders">Pesanan Selesai</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transaction.list', 4) }}" type="button" class="btn btn-filter" id="canceled-orders">Pesanan Dibatalkan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mx-2 my-4">
                                <div class="col-lg-12 px-2">
                                    @forelse($orders as $order)
                                    <div class="card shadow-1 mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p>{{ date("d F Y, H:i:s", strtotime($order->created_at)) }}</p>
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-3"/>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <h4 class="weight-600">Nomor Pemesanan</h4>
                                                    <h4 class="weight-500">({{ $order->invoice ?? '' }})</h4>
                                                </div>
                                                <div class="col-lg-5">
                                                    <p class="mb-half text-gray-3">Status Pemesanan</p>
                                                    <h4><strong>
                                                        @if($order->status == 0)
                                                        Menunggu Pembayaran
                                                        @elseif($order->status == 1)
                                                        Pesanan Diproses
                                                        @elseif($order->status == 2)
                                                        Pesanan Dikirim
                                                        @elseif($order->status == 3)
                                                        Pesanan Selesai
                                                        @elseif($order->status == 4)
                                                        Pesanan Dibatalkan
                                                        @endif</strong></h4>
                                                </div>
                                                <div class="col-lg-2">
                                                    <p class="mb-half text-gray-3">Total Pembayaran</p>
                                                    <h4><strong>Rp {{ number_format($order->total_cost, 2, ',', '.') ?? 'Rp 287.002' }}</strong></h4>
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-3"/>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    @foreach($order->details as $od)
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="media">
                                                                <div class="d-flex">
                                                                    <img src="{{ asset('storage/products/' . $od->variant->product->images->first()->filename) }}" width="100px" height="100px">
                                                                </div>
                                                                <div class="media-body">
                                                                    <h4 class="weight-600">
                                                                        <a class="text-orange" href="{{ url('/product/' . $od->variant->product->id) }}">{{ $od->variant->product->name }}</a>
                                                                    </h4>
                                                                    <p>{{ $od->weight ?? '120gr' }}</p>
                                                                    <p>Rp {{ number_format($od->price, 2, ',', '.') }}<span class="ml-4 text-gray-3">{{ $od->qty ?? '1 Produk (1 kg)' }}</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-lg-5">
                                                    <p class="mb-half text-gray-3">Total Harga Produk</p>
                                                    <h4><strong>Rp {{ number_format($order->subtotal, 2, ',', '.') }}</strong></h4>
                                                </div>
                                                <div class="col-lg-2">
                                                    @if($order->status == 0 && $order->payment->status == 0)
                                                    <a class="btn btn-orange weight-600" href="{{ route('payment.done', $order->id) }}">Bayar Sekarang</a>
                                                    @elseif($order->status == 0 && $order->payment->status == 1)
                                                    <div><strong>Menunggu Konfirmasi</strong></div>
                                                    @elseif($order->status == 1)
                                                    <div>Estimasi</div>
                                                    <div><strong>Akan diproses dalam <span> {{ "2-3" }} </span>hari kerja</strong></div>
                                                    @elseif($order->status == 2)
                                                    <button class="btn btn-orange weight-600" data-toggle="modal" data-target="#trackModal">Lacak Pengiriman</button>
                                                    @elseif($order->status == 3)
                                                    <button class="btn btn-orange weight-600">Beli Lagi</button>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <hr class="mt-2 mb-3"/>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <button class="btn btn-outline-orange weight-600">Detail Pemesanan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="card shadow-1">
                                        <div class="card-body">
                                            Belum ada pesanan.
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade w-100" id="trackModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width:1000rem">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute" style="color: #4F4F4F">Lacak Pengiriman</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row" style="color: #828282">
                        <div class="col-md-4">
                            <h6>Jasa Pengiriman</h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Lama Pengiriman</h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Estimasi Sampai</h6>
                        </div>
                    </div>
                    <div class="row" style="color: #4F4F4F">
                        <div class="col-md-4">
                            <h5>JNT</h5>
                        </div>
                        <div class="col-md-4">
                            <h5>Regular (4 - 5 hari)</h5>
                        </div>
                        <div class="col-md-4">
                            <h5>24 - 25 Des 2020</h5>
                        </div>
                    </div>
                    <div class="row pl-3 pt-2">
                        <h5 style="color: #4F4F4F">Nomor Resi : </h5><h5 style="color: #F37020"><strong>#JB0019791132</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function() {
        if(window.location.href.indexOf("/0") > -1) {
            $("#pending-orders").addClass('filter-active');
        } else if(window.location.href.indexOf("/1") > -1) {
            $("#processing-orders").addClass('filter-active');
        } else if(window.location.href.indexOf("/2") > -1) {
            $("#sent-orders").addClass('filter-active');
        } else if(window.location.href.indexOf("/3") > -1) {
            $("#finished-orders").addClass('filter-active');
        } else if(window.location.href.indexOf("/4") > -1) {
            $("#canceled-orders").addClass('filter-active');
        } else {
            $("#all-orders").addClass('filter-active');
        }
        
    });

    $(function () {
        $('#begin').daterangepicker({
            startDate: moment(),
            singleDatePicker: true,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoUpdateInput: true,
            linkedCalendars: true,
        });

        $('#end').daterangepicker({
            startDate: moment(),
            singleDatePicker: true,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoUpdateInput: true,
        });

        $('#end').on('change', function() {
            var start = $('#begin').val();
            var end = $('#end').val();

            $.ajax({
                data: {start: start, end: end},
                dataType: "JSON",
                method: "GET",
                url: "/transactions/date",
                success: function(res) {
                    console.log(res);
                }
            })
        })
    });
</script>
@endsection