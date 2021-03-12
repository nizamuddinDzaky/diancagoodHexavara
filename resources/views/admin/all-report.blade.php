@extends('layouts.admin')

@section('title')
<title>Laporan</title>
@endsection

@section('content')
<div class="container-fluid text-gray-2">
    <div class="row">
        <div class="col-lg-7 md-7 sm-7">
            <div class="btn-toolbar mb-1" role="toolbar">
                <a type="button" id="all_report" class="btn btn-outline-gray-2 weight-600 mr-4 mb-3" href="{{ route('administrator.all_report') }}">Semua Transaksi</a>
                <a type="button" id="product_report" class="btn btn-outline-gray-2 weight-600 mr-4 mb-3" href="{{ route('administrator.product_report') }}">Laporan Produk</a>
            </div>
        </div>
        <div class="col-lg-5 md-5 sm-5">
            <div class="btn-toolbar mb-1" role="toolbar">
                <form action="{{ route('administrator.all_report') }}" method="get">
                    <div class="input-group mb-3 float-left">
                        <div class="col-lg-5 md-5 sm-5 mb-3">
                            <input type="date" name="from_date" id="from_date" class="form-control border" placeholder="From Date">
                        </div>
                        <div class="col-lg-5 md-5 sm-5 mb-3">
                            <input type="date" name="to_date" id="to_date" class="form-control border" placeholder="To Date">
                        </div>
                        <div class="col-lg-2 md-2 sm-2">
                            <button class="btn btn-orange" type="submit" id="filter">Filter</button>
                        </div>
                        <!-- <input type="text" id="created_at" name="date" class="form-control"> -->
                        <!-- <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Filter</button>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <!-- <div class="col-lg-12 md-12 sm-12"> -->
        <div class="col-lg-3 pb-4">
            <div class="card border-orange h-100">
                <div class="card-body">
                    <h5 class="weight-600" style="color:#F37020">TOTAL TRANSAKSI</h5>
                    <h3 class="mt-3 mb-4 pb-4">{{ $total_order }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pb-4">
            <div class="card border-orange h-100">
                <div class="card-body">
                    <h5 class="weight-600" style="color:#F37020">PEMASUKAN</h5>
                    <h3 class="mt-3 mb-4 pb-4">{{ $monthly_income }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pb-4">
            <div class="card border-orange h-100">
                <div class="card-body">
                    <h5 class="weight-600" style="color:#F37020">PRODUK TERJUAL</h5>
                    <h3 class="mt-3 mb-4 pb-4">{{ $monthly_sold }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 pb-4">
            <div class="card border-orange h-100">
                <div class="card-body">
                    <h5 class="weight-600" style="color:#F37020">PRODUK TERJUAL (SOLD)</h5>
                    <h3 class="mt-3 mb-4 pb-4">{{ $sold }}</h3>
                </div>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 md-12 sm-12">
            <div class="table-responsive curved-border">
                <table class="table table-bordered text-gray-2 text-center">
                    <thead class="font-16">
                        <tr>
                            <th>
                                <span>Status</span>
                            </th>
                            <th>
                                <span>No Pemesanan</span>
                            </th>
                            <th>
                                <span>Tanggal</span>
                            </th>
                            <th>
                                <span>Tipe Transaksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $row)
                        <tr>
                            <td>
                                @if($row->status == 0)
                                <h5>Pending</h5>
                                @elseif($row->status == 1)
                                <h5>Proses</h5>
                                @elseif($row->status == 2)
                                <h5>Dikirim</h5>
                                @elseif($row->status == 3)
                                <h5>Selesai</h5>
                                @endif
                            </td>
                            <td class="weight-600">
                                <a class="text-orange" href="{{ route('administrator.orders.show', $row->id) }}" class="text-gray-2">{{ $row->invoice }}</a>
                            </td>
                            <td>
                                <h5>{{ $row->created_at->format('d-m-Y h:i:s A') }}</h5>
                            </td>
                            <td>
                                <h5>Transfer dari {{ $row->payment->transfer_to }}</h5>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $('#filter').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date != '' && to_date != '') {
                fetch_data(from_date, to_date);
            }
            else {
                alert('Both Date is required');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            if(window.location.href.indexOf("/report/all") > -1) {
                $("#all_product").addClass('filter-active-2');
            } else if(window.location.href.indexOf("/report/product") > -1) {
                $("#product_report").addClass('filter-active-2');
            }
        });
    </script>
@endsection