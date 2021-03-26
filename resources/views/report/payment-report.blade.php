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
                <form action="{{ route('administrator.payment_report') }}" method="get">
                    <div class="input-group mb-3 float-left">
                        <div class="col-lg-5 md-5 sm-5 mb-3">
                            <input type="date" name="from_date" id="from_date" class="form-control border" placeholder="From Date" value="{{ app('request')->input('to_date') ??  date('Y-m-d', strtotime( date( 'Y-m-d', strtotime( date('Y-m-d') ) ) . '1 month' ) ) }}">
                        </div>
                        <div class="col-lg-5 md-5 sm-5 mb-3">
                            <input type="date" name="to_date" id="to_date" class="form-control border" placeholder="To Date" value="{{ app('request')->input('from_date') ?? date('Y-m-d') }}">
                        </div>
                        <div class="col-lg-2 md-2 sm-2">
                            <button class="btn btn-orange" type="submit" id="filter">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row mb-1 float-right">
        <div class="col-lg-12 md-12 sm-12">
            <ul class="" style="list-style-type:none;">
                <li class="nav-item h-100">
                    <a href="" class="nav-link dropdown-toggle border" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Export</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('administrator.payment_report_pdf', ['from_date' => $start, 'to_date' => $end]) }}">PDF</a>
                        <a class="dropdown-item" href="{{ route('administrator.payment_report_excel', ['from_date' => $start, 'to_date' => $end]) }}">Excel</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 md-12 sm-12">
            <div class="table-responsive curved-border">
                <table id="myTable" class="table table-bordered text-gray-2 text-center">
                    <thead class="font-16">
                        <tr>
                            <th onclick="sortTable(0)" style="cursor: pointer;">
                                <span>Channel Pembayaran</span>
                                <i class="material-icons md-18">sort</i>
                            </th>
                            <th>
                                <span>Transaksi</span>
                            </th>
                            <th onclick="sortTable(2)" style="cursor: pointer;">
                                <span>Tanggal Transaksi</span>
                                <i class="material-icons md-18">sort</i>
                            </th>
                            <th>
                                <span>Jumlah Pembayaran</span>
                            </th>
                            <th>
                                <span>Pembayaran Bersih</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $row)
                        <tr>
                            <td class="weight-600">
                                <h5>{{ $row->payment->method }} {{ $row->payment->transfer_to }}</h5>
                            </td>
                            <td>
                                <h5>Penjualan</h5>
                            </td>
                            <td>
                                <h5>{{ $row->created_at->format('d-m-Y h:i:s A') }}</h5>
                            </td>
                            <td>
                                <h5>1</h5>
                            </td>
                            <td>
                                <h5>Rp {{ number_format($row->payment->amount) }}</h5>
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