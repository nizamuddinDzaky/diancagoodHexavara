@extends('layouts.admin')

@section('title')
<title>Detail Pemesanan</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card curved-border mb-5">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="btn-group py-4">
                            <ul class="filter-buttons">
                                <li>
                                    <a href="{{ route('administrator.tracking', 0) }}" type="button"
                                        class="btn btn-filter px-4 mx-5" id="pending-orders">Menunggu Pembayaran</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.tracking', 1) }}" type="button"
                                        class="btn btn-filter px-5 mx-5" id="processing-orders">Pesanan Diproses</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.tracking', 2) }}" type="button"
                                        class="btn btn-filter px-5 mx-5" id="sent-orders">Pesanan Dikirim</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.tracking', 3) }}" type="button"
                                        class="btn btn-filter px-5 mx-5" id="finished-orders">Pesanan Selesai</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.tracking', 4) }}" type="button"
                                        class="btn btn-filter px-5 mx-5" id="canceled-orders">Pesanan Dibatalkan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body px-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <p>{{ $order->created_at }}</p>
                        </div>
                    </div>
                    <hr class="mt-2 mb-3" />
                    <div class="row">
                        <div class="col-lg-5">
                            <h4 class="weight-600">Nomor Pemesanan</h4>
                            <h4 class="weight-500">{{ $order->invoice }}</h4>
                        </div>
                        <div class="col-lg-5">
                            <h4 class="weight-600">Nama</h4>
                            <h4 class="weight-500">{{ $order->customer_name }}</h4>
                        </div>
                        <div class="col-lg-2">
                            <p class="mb-half text-gray-3">Status Pemesanan</p>
                            <h4>
                                <strong>
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
                                    @endif
                                </strong>
                            </h4>
                        </div>
                    </div>
                    <hr class="mt-2 mb-3" />
                    <div class="row">
                        <div class="col-lg-5">
                            @foreach($order->details as $od)
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="{{ asset('storage/products/' . $od->variant->product->images->first()->filename) }}"
                                                width="100px" height="100px">
                                        </div>
                                        <div class="media-body">
                                            <h4 class="weight-600">
                                                <a
                                                    href="{{ url('/product/' . $od->variant->product->id) }}">{{ $od->variant->product->name }}</a>
                                            </h4>
                                            <p>{{ $od->variant->name }}</p>
                                            <p>Rp {{ number_format($od->price, 2, ',', '.') }}<span
                                                    class="ml-4 text-gray-3">{{ $od->qty }} ({{ $od->weight }}
                                                    gr)</span>
                                            </p>
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
                            <p class="mb-half text-gray-3">Total Pembayaran</p>
                            <h4><strong>Rp {{ number_format($order->total_cost, 2, ',', '.') }}</strong></h4>
                        </div>
                    </div>
                    <hr class="mt-2 mb-3" />
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="font-16">{{ $order->customer_address }}</p>
                        </div>
                    </div>
                    <hr class="mt-2 mb-3" />
                    @if($order->status == 0)
                    <div class="row">
                        <div class="col-lg-12 text-center divider">
                            <h3 class="weight-600">Bukti Pembayaran</h3>
                        </div>
                    </div>
                    <form action="{{ route('administrator.order.update_payment') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-4">
                                <label class="form-label">Nomor Pemesanan</label>
                                <input type="text" name="invoice" class="form-control bg-white border-3"
                                    value="{{ $order->invoice }}" disabled>
                                <input type="hidden" name="order_id"
                                    value="{{ $order->id }}" disabled>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-5 mt-4">
                                <label class="form-label">Jumlah Transfer</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-3 border-3">Rp</div>
                                    </div>
                                    <input type="text" name="amount" class="form-control bg-white border-3"
                                        value="{{ $order->payment->amount ?? '' }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-4">
                                <label class="form-label">Bank Tujuan</label>
                                <input type="text" name="transfer_to" class="form-control bg-white border-3"
                                    value="{{ $order->payment->transfer_to ?? '' }}" disabled>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-5 mt-4">
                                <label class="form-label">Tanggal Transfer</label>
                                <input type="text" name="transfer_date" class="form-control bg-white border-3"
                                    value="{{ $order->payment->transfer_date ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-4">
                                <label class="form-label">Bank Pengirim</label>
                                <input type="text" name="transfer_from_bank" class="form-control bg-white border-3"
                                    value="{{ $order->payment->transfer_from_bank ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-4">
                                <label class="form-label">Nomor Rekening Pengirim</label>
                                <input type="text" name="transfer_from_account" class="form-control bg-white border-3"
                                    value="{{ $order->payment->transfer_from_account ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-4">
                                <label class="form-label">Nama Pemilik Pengirim</label>
                                <input type="text" name="name" class="form-control bg-white border-3"
                                    value="{{ $order->payment->name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7 mt-4"></div>
                            <div class="col-lg-3 mt-4 text-right">
                                <h4>Apakah Bukti Pembayaran Sudah Benar?</h4>
                                <button type="button" class="btn btn-outline-gray-3 font-16 px-5 py-2 m-2"
                                    data-dismiss="modal">Belum</button>
                                <button type="submit" class="btn btn-orange font-16 px-5 py-2 m-2">Sudah</button>
                            </div>
                        </div>
                    </form>

                    @elseif($order->status > 0 && $order->status != 4)
                    <div class="card curved-border mt-5 mb-5">
                        <div class="card-body px-5 font-18">
                            <div class="card-title text-center mb-4">
                                <h5 class="weight-600 font-18">Bukti Pembayaran Telah Valid</h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Tipe Pembayaran
                                </div>
                                <div class="col-lg-6">
                                    Bank Transfer
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Bank Tujuan
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->payment->transfer_to ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Bank Pengirim
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->payment->transfer_from_bank ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Nomor Rekening Pengirim
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->payment->transfer_from_account ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Nama Pemilik Rekening
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->payment->name ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Jumlah Transfer
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->payment->amount ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Tanggal Transfer
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->payment->transfer_date ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($order->status == 1)
                    <div class="row">
                        <div class="col-lg-12 text-center divider">
                            <h3 class="weight-600">Pengiriman</h3>
                        </div>
                    </div>
                    <form action="{{ route('administrator.order.update_tracking') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 mt-4">
                                <label class="form-label">Nomor Pemesanan</label>
                                <input type="text" name="invoice" class="form-control bg-white border-3"
                                    value="{{ $order->invoice }}" disabled>
                                <input type="hidden" name="order_id"
                                    value="{{ $order->id }}" disabled>
                            </div>
                            <div class="col-lg-5 mt-4">
                                <label class="form-label">Alamat Tujuan</label>
                                <input type="text" name="address" class="form-control bg-white border-3"
                                        value="{{ $order->customer_address ?? '' }}" disabled>
                            </div>
                            <div class="col-lg-2 mt-4">
                                <label class="form-label">Kabupaten/Kota Tujuan</label>
                                <input type="text" name="address" class="form-control bg-white border-3"
                                        value="{{ $order->district->city->name ?? '' }}" disabled>
                            </div>
                            <div class="col-lg-2 mt-4">
                                <label class="form-label">Provinsi Tujuan</label>
                                <input type="text" name="address" class="form-control bg-white border-3"
                                        value="{{ $order->district->city->province->name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 mt-4">
                                <label class="form-label">Kurir</label>
                                <input type="text" name="courier" value="{{ $order->shipping }}" class="form-control bg-white border-3" disabled>
                            </div>
                            <div class="col-lg-3 mt-4">
                                <label class="form-label">Nomor Resi</label>
                                <input type="text" name="tracking_number" class="form-control bg-white border-3">
                            </div>
                            <div class="col-lg-2 mt-4">
                                <label class="form-label">Tanggal Pengiriman</label>
                                <input type="text" name="shipping_date" class="form-control bg-white border-3">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 mt-4">
                                <h4>Apakah Data Pengiriman Sudah Benar?</h4>
                                <button type="submit" class="btn btn-orange font-16 px-5 py-2 m-2">Sudah</button>
                            </div>
                        </div>
                    </form>
                    @endif

                    @if($order->status > 1 && $order->status != 4)
                    <div class="card curved-border mt-5 mb-5">
                        <div class="card-body px-5 font-18">
                            <div class="card-title text-center mb-4">
                                <h5 class="weight-600 font-18">Data Pengiriman</h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Kurir
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->shipping ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Nomor Resi
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->tracking_number ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Alamat Tujuan
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->customer_address ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Kabupaten/Kota Tujuan
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->district->city->name ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Provinsi Tujuan
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->district->city->province->name ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Biaya Kurir
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->shipping_cost ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 weight-600">
                                    Tanggal Pengiriman
                                </div>
                                <div class="col-lg-6">
                                    {{ $order->shipping_date ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
// if orderstatus is ... then select filter_buttons
</script>
@endsection