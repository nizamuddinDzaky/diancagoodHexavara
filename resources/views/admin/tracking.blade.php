@extends('layouts.admin')

@section('title')
<title>Tracking</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="table-responsive curved-border">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="btn-group py-4">
                            <ul class="filter-buttons">
                                <li>
                                    <a href="{{ route('administrator.tracking', 0) }}" type="button" class="btn btn-filter px-5 mx-5 "
                                        id="pending-orders">Menunggu Pembayaran</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.tracking', 1) }}" type="button" class="btn btn-filter px-5 mx-5"
                                        id="processing-orders">Pesanan Diproses</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.tracking', 2) }}" type="button" class="btn btn-filter px-5 mx-5"
                                        id="sent-orders">Pesanan Dikirim</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.tracking', 3) }}" type="button" class="btn btn-filter px-5 mx-5"
                                        id="finished-orders">Pesanan Selesai</a>
                                </li>
                                <li>
                                    <a href="{{ route('administrator.tracking', 4) }}" type="button" class="btn btn-filter"
                                        id="canceled-orders">Pesanan Dibatalkan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered text-gray-2">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-2">No Pemesanan</th>
                            <th class="col-2">Nama</th>
                            <th class="col-4">Alamat</th>
                            <th class="col-1">Tanggal</th>
                            <th class="col-1">Status</th>
                            <th class="col-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                        <tr class="d-flex">
                            <td class="col-2 weight-600"><a href="{{ route('administrator.orders.show', $o->id) }}" class="text-orange">{{ $o->invoice }}</a></td>
                            <td class="col-2">{{ $o->customer_name }}</td>
                            <td class="col-4">{{ $o->customer_address }}</td>
                            <td class="col-1">{{ $o->created_at }}</td>
                            <td class="col-1">
                                @if($o->status == 0)
                                Pending
                                @elseif($o->status == 1)
                                Proses
                                @elseif($o->status == 2)
                                Dikirim
                                @elseif($o->status == 3)
                                Selesai
                                @endif
                            </td>
                            <td class="col-2">
                                <button class="btn btn-outline-orange dropdown-toggle" data-toggle="dropdown" role="button">Ubah</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 0]) }}">Pending</a>
                                    <a class="dropdown-item" href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 1]) }}">Proses</a>
                                    <a class="dropdown-item" href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 2]) }}">Dikirim</a>
                                    <a class="dropdown-item" href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 3]) }}">Selesai</a>
                                    <a class="dropdown-item" href="{{ route('administrator.tracking.update_status', ['id' => $o->id, 'status' => 4]) }}">Dibatalkan</a>

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

@endsection

@section('js')
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
        }
    });
</script>
@endsection