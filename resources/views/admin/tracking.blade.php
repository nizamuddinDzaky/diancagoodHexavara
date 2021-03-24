@extends('layouts.admin')

@section('title')
<title>Tracking</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row pb-100">
        <div class="col-lg-12">
            <div class="row px-4">
                <div class="col-lg-12 col-xs-12 text-center">
                    <div class="btn-group order-group py-4">
                        <a href="{{ route('administrator.tracking', 0) }}" type="button" class="btn btn-filter"
                            id="pending-orders">Menunggu Pembayaran <span class="badge badge-orange ml-2">{{ $menunggu }}</span></a>
                        <a href="{{ route('administrator.tracking', 1) }}" type="button" class="btn btn-filter"
                            id="processing-orders">Pesanan Diproses <span class="badge badge-orange ml-2">{{ $diproses }}</span></a>
                        <a href="{{ route('administrator.tracking', 2) }}" type="button" class="btn btn-filter"
                            id="sent-orders">Pesanan Dikirim <span class="badge badge-orange ml-2">{{ $dikirim }}</span></a>
                        <a href="{{ route('administrator.tracking', 3) }}" type="button" class="btn btn-filter"
                            id="finished-orders">Pesanan Selesai <span class="badge badge-orange ml-2">{{ $selesai }}</span></a>
                        <a href="{{ route('administrator.tracking', 4) }}" type="button" class="btn btn-filter"
                            id="canceled-orders">Pesanan Dibatalkan <span class="badge badge-orange ml-2">{{ $batal }}</span></a>
                    </div>
                </div>
            </div>
            <div class="row px-4">
                <div class="table-responsive curved-border">
                    <table class="table table-bordered text-gray-2">
                        <thead>
                            <tr>
                                <th class="px-3">ID</th>
                                <th class="px-3">Nama</th>
                                <th class="px-3">Alamat</th>
                                <th class="px-3">Tanggal</th>
                                <th class="px-3">Status</th>
                                <th class="px-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $o)
                            <tr>
                                <td class="weight-600 font-14 px-3 td-wrap"><a href="{{ route('administrator.orders.show', $o->id) }}"
                                        class="text-orange">{{ $o->invoice }}</a></td>
                                <td class="font-14 px-3 td-wrap">{{ $o->customer_name }}</td>
                                <td class="font-14 px-3 td-wrap">{{ $o->customer_address }}</td>
                                <td class="font-14 px-3 td-wrap">{{ date("d F Y, H:i:s", strtotime($o->created_at)) }}</td>
                                <td class="font-14 px-3 td-wrap">{!! $o->status_label !!}</td>
                                <td class="td-wrap px-3">
                                    <button class="btn btn-outline-orange dropdown-toggle font-14" data-toggle="dropdown"
                                        role="button">Ubah</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 0]) }}">Pending</a>
                                        <a class="dropdown-item"
                                            href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 1]) }}">Proses</a>
                                        <a class="dropdown-item"
                                            href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 2]) }}">Dikirim</a>
                                        <a class="dropdown-item"
                                            href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 3]) }}">Selesai</a>
                                        <a class="dropdown-item"
                                            href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 4]) }}">Dibatalkan</a>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="d-flex">
                                <td class="col-12">Tidak ada pesanan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function() {
    if (window.location.href.indexOf("/0") > -1) {
        $("#pending-orders").addClass('filter-active');
    } else if (window.location.href.indexOf("/1") > -1) {
        $("#processing-orders").addClass('filter-active');
    } else if (window.location.href.indexOf("/2") > -1) {
        $("#sent-orders").addClass('filter-active');
    } else if (window.location.href.indexOf("/3") > -1) {
        $("#finished-orders").addClass('filter-active');
    } else if (window.location.href.indexOf("/4") > -1) {
        $("#canceled-orders").addClass('filter-active');
    }
});
</script>
@endsection