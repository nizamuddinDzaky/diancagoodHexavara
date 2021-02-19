@extends('layouts.admin')

@section('title')
<title>Order</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive curved-border">
                <table class="table table-bordered text-gray-2">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-2">No Pemesanan</th>
                            <th class="col-2">Nama</th>
                            <th class="col-4">Alamat</th>
                            <th class="col-2">Tanggal</th>
                            <th class="col-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                        <tr class="d-flex">
                            <td class="col-2 weight-600">{{ $o->invoice }}</td>
                            <td class="col-2">{{ $o->customer_name }}</td>
                            <td class="col-4">{{ $o->customer_address }}</td>
                            <td class="col-2">{{ $o->created_at }}</td>
                            <td class="col-2">
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
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection