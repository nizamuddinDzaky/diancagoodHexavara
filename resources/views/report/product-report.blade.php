@extends('layouts.admin')

@section('title')
<title>Laporan</title>
@endsection

@section('content')
<div class="container-fluid text-gray-2">
    <div class="row">
        <div class="col-lg-7 md-7 sm-7">
            <div class="btn-toolbar mb-1" role="toolbar">
                <a type="button" id="all_report" class="btn btn-outline-gray-2 weight-600 mr-2 mb-3" href="{{ route('administrator.all_report') }}">Semua Transaksi</a>
                <a type="button" id="product_report" class="btn btn-outline-gray-2 weight-600 mr-2 mb-3" href="{{ route('administrator.product_report') }}">Laporan Produk</a>
                <a type="button" id="payment_report" class="btn btn-outline-gray-2 weight-600 mr-2 mb-3" href="{{ route('administrator.payment_report') }}">Laporan Pembayaran</a>
                <a type="button" id="sales_report" class="btn btn-outline-gray-2 weight-600 mb-3" href="{{ route('administrator.sales_report') }}">Laporan Penjualan</a>
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
        <div class="col-lg-5 md-5 sm-5">
            <ul class="" style="list-style-type:none;">
                <li class="nav-item h-100">
                    <a href="" class="nav-link dropdown-toggle border" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Export</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('administrator.product_report_pdf', ['from_date' => $start, 'to_date' => $end]) }}">PDF</a>
                        <a class="dropdown-item" href="{{ route('administrator.product_report_excel', ['from_date' => $start, 'to_date' => $end]) }}">Excel</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-lg-7 md-7 sm-7">
            <ul class="" style="list-style-type:none;">
                <li class="nav-item h-100">
                    <a href="{{ route('administrator.product_report') }}" class="nav-link dropdown-toggle border" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Semua Produk</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('administrator.product_report') }}">Semua Produk</a>
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
                <table id="myTable" class="table table-bordered text-gray-2">
                    <thead class="font-16">
                        <tr>
                            <th onclick="sortTable(0)">
                                <span>Nama Produk</span>
                            </th>
                            <th onclick="sortTable(1)">
                                <span>SKU</span>
                            </th>
                            <th>
                                <span>Unit Terjual</span>
                            </th>
                            <th>
                                <span>Omzet Penjualan</span>
                            </th>
                            <th>
                                <span>Pengembalian Dana</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $row)
                        @foreach ($row->variant as $val)
                        <tr>
                            <td>
                                <div class="row">
                                    <img class="ml-4 mr-2" src="{{ asset('storage/products/' . $val->product->images->first()->filename) }}" width="100px" height="100px">
                                    <div class="align-self-center mt-2"><a href="{{ route('administrator.edit_product', $val->product->id) }}" style="color:black"><h5>{{ $val->product->name }} {{ $val->name }}</h5></a></div>
                                </div>
                                
                            </td>
                            <td class="weight-600">
                                <div class="mt-3 pt-4">
                                    <a class="text-orange" href="{{ route('administrator.edit_product', $val->product->id) }}" style="color:black">PR{{ $val->product->id }}VR{{ $val->id }}</a>
                                </div>
                            </td>
                            <td>
                                <div class="mt-3 pt-4 text-center"><h5>{{ $val->sold }}</h5></div>
                            </td>
                            <td>
                                <div class="mt-3 pt-4 text-center"><h5>Rp {{ number_format($val->total) }}</h5></div>
                            </td>
                            <td>
                                <div class="mt-3 pt-4 text-center"><h5>Rp 0</h5></div>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
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
        $(document).ready(function() {
            if(window.location.href.indexOf("/report/all") > -1) {
                $("#all_product").addClass('filter-active-2');
            } 
            else if(window.location.href.indexOf("/report/product") > -1) {
                $("#product_report").addClass('filter-active-2');
            }
            else if(window.location.href.indexOf("/report/payment") > -1) {
                $("#payment_report").addClass('filter-active-2');
            }
            else if(window.location.href.indexOf("/report/sales") > -1) {
                $("#sales_report").addClass('filter-active-2');
            }
        });
    </script>
    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            
            dir = "asc"; 
            
            while (switching) {
                switching = false;
                rows = table.rows;
                
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch= true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount ++;      
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
@endsection