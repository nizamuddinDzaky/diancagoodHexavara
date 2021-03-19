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
            width:120px;
            text-align: center;
        }
        th{
            background-color: #f0f0f0;
        }
    </style>
</head>
@php
use App\Models\Order;
use App\Models\Payment;

$total_order = 0;
$monthly_income = 0;
foreach ($orders as $f) {
    $total_order += Order::where('id', $f->id)->count();
    $monthly_income += Order::where('id', $f->id)->sum('subtotal');
}
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 md-12 sm-12">
            <h3 style="align-center">LAPORAN TRANSAKSI DIANCAGOODS</h3>
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
                            <span>Kode Pesanan</span>
                        </th>
                        <th>
                            <span>Jenis</span>
                        </th>
                        <th>
                            <span>Tanggal Transaksi</span>
                        </th>
                        <th>
                            <span>Transaksi</span>
                        </th>
                        <th>
                            <span>Total Transaksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $row)
                    <tr>
                        
                        <td class="weight-600">
                            <div style="max-height:1px;">
                                <h5>{{ $row->invoice }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>Penjualan</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>{{ $row->created_at->format('d-m-Y') }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>1</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>Rp {{ number_format($row->subtotal) }}</h5>
                            </div>
                        </td>
                        
                    </tr>
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
                            <h5>{{ $total_order }}</h5>
                        </td>
                        <td>
                            <h5>Rp {{ number_format($monthly_income) }}</h5>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>