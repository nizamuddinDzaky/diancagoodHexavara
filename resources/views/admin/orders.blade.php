@extends('layouts.admin')

@section('title')
<title>Order</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row pb-100">
        <div class="col-lg-12">
            <div class="table-responsive curved-border">
                <table class="table table-bordered text-gray-2">
                    <thead>
                        <tr>
                            <th class="px-3">ID</th>
                            <th class="px-3">Nama</th>
                            <th class="px-3">Alamat</th>
                            <th class="px-3">Tanggal</th>
                            <th class="px-3">Promo</th>
                            <th class="px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                        <tr>
                            <td class="weight-600 font-14 px-3"><a class="text-orange" href="{{ route('administrator.orders.show', $o->id) }}" class="text-orange">{{ $o->invoice }}</a></td>
                            <td class="font-14 px-3">{{ $o->customer_name }}</td>
                            <td class="font-14 px-3">{{ $o->address->address }}</td>
                            <td class="font-14 px-3">{{ date("d F Y, H:i:s", strtotime($o->created_at)) }}</td>
                            <td class="font-14 px-3">Rp {{ number_format($o->details->sum('promo'), 2, ',', '.') }}</td>
                            <td class="font-14 px-3">{!! $o->status_label !!}</td>
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