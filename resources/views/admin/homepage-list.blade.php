@extends('layouts.admin')

@section('title')
<title>Homepage Management</title>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid text-gray-2">
    <div class="row float-right mr-1">
        <div class="col-ld-12 md-12 sm-12">
            <button class="btn btn-orange weight-600 mb-3" data-toggle="modal" data-target="#add-product">Add Product</button>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row pb-100">
        <div class="col-lg-12 md-12 sm-12">
            <div class="table-responsive curved-border">
                <table id="myTable" class="table table-bordered text-gray-2 text-center">
                    <thead class="font-16">
                        <tr>
                            <th onclick="sortTable(0)">
                                <span>Nama Produk</span>
                            </th>
                            <th>
                                <span>Harga</span>
                            </th>
                            <th>
                                <span>Stok</span>
                            </th>
                            <th onclick="sortTable(3)">
                                <span>Status</span>
                            </th>
                            <th>
                                <span>Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="align-self-center">
                            @forelse ($product as $row)
                            <td class="weight-600">
                                <div class="row">
                                    <img class="ml-4 mr-2" src="{{ asset('storage/products/' . $row->images->first()->filename) }}" width="100px" height="100px">
                                    <div class="align-self-center mt-2"><a href="{{ route('administrator.edit_product', $row->id) }}" style="color:black"><h5>{{ $row->name }}</h5></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="mt-3 pt-4">
                                @if($row->variant->all() != NULL)
                                    @if( number_format($row->variant->first()->price) != number_format($row->variant->last()->price))
                                    <h5>Rp {{ number_format($row->variant->first()->price) }} - Rp
                                    {{ number_format($row->variant->last()->price) }}</h5>
                                    @else
                                    <h5>Rp {{ number_format($row->variant->first()->price) }}</h5>
                                    @endif
                                @endif
                                </div>
                            </td>
                            <td>
                                <div class="mt-3 pt-4">
                                    <h5>{{ $row->variant->sum('stock') }}</h5>
                                </div>
                            </td>
                            <td>
                                <div class="mt-3 pt-4">
                                    @if ($row->is_featured == 1)
                                    <h5>Produk Terbaru</h5>
                                    @elseif ($row->is_featured == 2)
                                    <h5>Produk Terlaris</h5>
                                    @elseif ($row->is_featured == 3)
                                    <h5>Produk Terpilih</h5>
                                    @else
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="mt-3 pt-3">
                                    <button class="btn btn-outline-orange dropdown-toggle" data-toggle="dropdown"
                                        role="button">Aksi</button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item"
                                        data-toggle="modal" data-target="#update-product" value="{{ $row->id }}">Ubah</button>
                                        <form action="{{ route('administrator.homepage.delete', ['id' => $row->id]) }}"
                                            method="post">
                                            @csrf
                                            <button class="dropdown-item"
                                                onclick="return confirm('Hapus Produk?')">Hapus/Batalkan</button>
                                        </form>
                                    </div>
                                <!-- <div class="mt-3 pt-3">
                                    <a type="button" id="" class="btn btn-danger weight-600 mb-3" href="">Delete</a>
                                </div> -->
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
<div class="modal fade w-100" id="add-product" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute">Tambah Produk Pilihan</h3>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{ route('administrator.homepage.create') }}" method="POST">
                        @csrf
                        <div class="form-group px-2">
                            <label for="type">Jenis Kategori</label>
                            <select class="form-control border-3" name="type" id="type">
                                <option value="">Pilih</option>
                                <option value="1">Produk Terbaru</option>
                                <option value="2">Produk Terlaris</option>
                                <option value="3">Produk Terpilih</option>
                            </select>
                        </div>
                        <div class="form-group px-2">
                            <label for="product_select">Produk</label>
                            <select id="product_select" name="product_select" class="form-control border-3">
                                @forelse($product_option as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group px-2 text-center">
                            <button class="btn btn-orange">Tambah Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="update-product" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute">Update Produk</h3>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{ route('administrator.homepage.update') }}" method="POST" id="product_update_form">
                        @csrf
                        <div class="form-group px-2">
                            <label for="type">Jenis Kategori</label>
                            <select class="form-control border-3" name="type" id="type">
                                <option value="">Pilih</option>
                                <option value="1">Produk Terbaru</option>
                                <option value="2">Produk Terlaris</option>
                                <option value="3">Produk Terpilih</option>
                            </select>
                        </div>
                        <div class="form-group px-2">
                            <label for="input_name">Produk</label>
                            <input type="text" id="input_name" name="name" class="form-control border-3" disabled>
                            <input type="text" id="input_id" name="id" class="form-control border-3" hidden>
                        </div>
                        <div class="form-group px-2 text-center">
                            <button class="btn btn-outline-gray" data-dismiss="modal">Batal</button>
                            <button type="submit" id="product_update" class="btn btn-orange">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    <script>
        $("#product_select").select2({
            width: '100%'
        });

        $('#product_update').click(function (e) {
            e.preventDefault();
            $('#product_update_form').submit();
        });

        $("#update-product").on('show.bs.modal', function(e) {
            var product_id = $(e.relatedTarget).val();
            $.ajax({
                url: '/admin/homepage-management/change/' + product_id,
                type: 'GET',
                data: {product_id: parseInt(product_id)},
                dataType: 'JSON',
                success: function(res){
                    console.log(res);
                    $("#input_name").val(res.name);
                    $("#input_id").val(res.id);
                },
                error: function(xhr, status, err) {
                    console.log(xhr.responseText);
                },
            })
        });
    </script>
@endsection