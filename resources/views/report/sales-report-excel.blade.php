<head>
    <style>
        .container{
            margin:0 auto;
            margin-top:35px;
            padding:40px;
            width:auto;
            height:auto;
            background-color:#fff;
        }
        table{
            border:1px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:auto;
        }
        td, tr, th{
            padding:4px;
            border:1px solid #333;
            width:100px;
            text-align: center;
        }
        th{
            background-color: #f0f0f0;
        }
    </style>
</head>
@php
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\Product;

$total_sales = 0;
$monthly_income = 0;
foreach ($orders as $f) {
    $monthly_income += OrderDetail::where('order_id', $f->id)->sum('price');
    $total_sales += OrderDetail::where('order_id', $f->id)->sum('qty');
}
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 md-12 sm-12">
            <h3 style="align-center">LAPORAN PENJUALAN DIANCAGOODS</h3>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 md-12 sm-12">
            <table class="table text-center">
                <thead class="font-16">
                    <tr>
                        <th>
                            <span>Nama Produk</span>
                        </th>
                        <th>
                            <span>SKU</span>
                        </th>
                        <th>
                            <span>Kode Pesanan</span>
                        </th>
                        <th>
                            <span>Unit Terjual</span>
                        </th>
                        <th>
                            <span>Omset Penjualan</span>
                        </th>
                        <th>
                            <span>Pengembalian Dana</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $row)
                    @foreach ($row->details as $val)
                    <tr>
                        
                        <td class="weight-600">
                            <div style="max-height:1px;">
                                <h5>{{ $val->variant->product->name }} {{ $val->variant->name }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>PR{{ $val->variant->product->id }}VR{{ $val->variant->id }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>{{ $row->invoice }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>{{ $val->qty }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>Rp {{ number_format($val->price) }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>Rp 0</h5>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <td>
                            <h5>{{ $total_sales }}</h5>
                        </td>
                        <td>
                            <h5>Rp {{ number_format($monthly_income) }}</h5>
                        </td>
                        <td>
                            <h5>Rp 0</h5>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>