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
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 md-12 sm-12">
            <h3 style="align-center">LAPORAN PRODUK DIANCAGOODS</h3>
            <h5>{!! date('d/M/Y', strtotime($start)) !!} - {!! date('d/M/Y', strtotime($end)) !!}</h5>
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
                        <td class="weight-600">
                            <div style="max-height:1px;">
                                <h5>{{ $val->product->name }} {{ $val->name }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>PR{{ $val->product->id }}VR{{ $val->id }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>{{ $val->sold }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>Rp {{ number_format($val->total) }}</h5>
                            </div>
                        </td>
                        <td>
                            <div style="max-height:1px;">
                                <h5>Rp 0</h5>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <td>
                            <h5>{{ $total_count }}</h5>
                        </td>
                        <td>
                            <h5>Rp {{ number_format($total_sold) }}</h5>
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