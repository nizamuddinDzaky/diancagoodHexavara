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
                <a type="button" id="product_report" class="btn btn-orange weight-600 mr-4 mb-3" href="{{ route('administrator.product_report') }}">Laporan Produk</a>
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
    <div class="row mb-1 float-right">
        <div class="col-lg-12 md-12 sm-12">
            <ul class="" style="list-style-type:none;">
                <li class="nav-item h-100">
                    <a href="{{ route('administrator.product_report') }}" class="nav-link dropdown-toggle border" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Semua Produk</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('administrator.product_sold_report') }}">Produk Terjual</a>
                        <a class="dropdown-item" href="{{ route('administrator.product_soldout_report') }}">Produk Habis</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive curved-border">
                <table class="table table-bordered text-gray-2">
                    <thead class="font-16">
                        <tr>
                            <th>
                                <span>Nama Produk</span>
                            </th>
                            <th>
                                <span>Harga</span>
                            </th>
                            <th>
                                <span>Stok</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $row)
                        <tr>
                            <td>
                                <div class="row">
                                    <img class="ml-4 mr-2" src="{{ asset('storage/products/' . $row->images->first()->filename) }}" width="100px" height="100px">
                                    <div class="align-self-center mt-2"><a href="{{ route('administrator.edit_product', $row->id) }}" style="color:black"><h5>{{ $row->name }}</h5></a></div>
                                </div>
                                
                            </td>
                            <td>
                                @if( number_format($row->variant->first()->price) != number_format($row->variant->last()->price))
                                <div class="mt-3 pt-4"><h5>Rp {{ number_format($row->variant->first()->price) }} - Rp {{ number_format($row->variant->last()->price) }}</h5></div>
                                @else
                                <div class="mt-3 pt-4"><h5>Rp {{ number_format($row->variant->first()->price) }}</h5></div>
                                @endif
                            </td>
                            <td>
                                @if( $row->variant->sum('stock') == 0 )
                                <div class="mt-3 pt-4"><h5>Sold</h5></div>
                                @else
                                <div class="mt-3 pt-4"><h5>{{ $row->variant->sum('stock') }}</h5></div>
                                @endif
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
@endsection