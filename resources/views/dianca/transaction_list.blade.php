@extends('layouts.store')

@section('title')
    <title>Pembelian</title>
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
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
                                <div class="col-lg-12 px-2">
                                    <p>Lihat Transaksi: </p>
                                </div>
                            </div>
                            <div class="row mx-2 my-2">
                                <div class="col-lg-12 px-2">
                                    <h4>Filter Status</h4>
                                    <div class="filter_buttons">
                                        <button class="btn btn-filter" id="all-orders">Semua</button>
                                        <button class="btn btn-filter" id="pending-orders">Menunggu Pembayaran</button>
                                        <button class="btn btn-filter" id="processing-orders">Pesanan Diproses</button>
                                        <button class="btn btn-filter" id="sent-orders">Pesanan Dikirim</button>
                                        <button class="btn btn-filter" id="finished-orders">Pesanan Selesai</button>
                                        <button class="btn btn-filter" id="canceled-orders">Pesanan Dibatalkan</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-2 my-4">
                                <div class="col-lg-12 px-2">
                                    <div class="card shadow-1">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p>{{ $order->date ?? '28 Desember 2020' }}</p>
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-3"/>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <h4 class="weight-600">Nomor Pemesanan</h4>
                                                    <h4 class="weight-500">{{ $order->id ?? '(DG001228122020AV)' }}</h4>
                                                </div>
                                                <div class="col-lg-5">
                                                    <p class="mb-half text-gray-3">Status Pemesanan</p>
                                                    <h4>{{ $order->status ?? 'Pesanan Diproses' }}</h4>
                                                </div>
                                                <div class="col-lg-2">
                                                    <p class="mb-half text-gray-3">Total Pembayaran</p>
                                                    <h4>{{ $order->total ?? 'Rp 287.002' }}</h4>
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-3"/>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="media">
                                                        <div class="d-flex">
                                                            <img src="{{ asset('img/products/somebymi_bbb.png') }}" width="100px" height="100px">
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="weight-600">{{ $od->name ?? 'SOMEBYMI BYE BYE BLACKHEAD' }}</h4>
                                                            <p>{{ $od->weight ?? '120gr' }}</p>
                                                            <p>{{ $od->price ?? 'Rp 279.000' }}<span class="ml-4 text-gray-3">{{ $od->quantity ?? '1 Produk (1 kg)' }}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <p class="mb-half text-gray-3">Total Harga Produk</p>
                                                    <h4>{{ ($od->price_total) ?? 'Rp 279.000' }}</h4>
                                                </div>
                                                <div class="col-lg-2">
                                                    {{-- if order is being delivered --}}
                                                    <button class="btn btn-orange weight-600" style="padding:9px 20px">Lacak Pengiriman</button>
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
    $(document).ready(function() {
        $("#all-orders").addClass('filter-active');
    });
</script>
@endsection