@extends('layouts.admin')

@section('title')
<title>Produk</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive curved-border">
                <table class="table table-bordered text-gray-2">
                    <thead class="font-18">
                        <tr class="d-flex">
                            <th class="col-6 product-toggle" id="all-products" onclick="showAllProducts()">
                                <span>Semua Produk</span>
                            </th>
                            <th class="col-6 product-toggle" id="new-products" onclick="showNewProducts()">
                                <span>Produk Terbaru</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        @include('admin.products-list')
                    </tbody>
                    <tfoot>
                        <tr class="d-flex">
                            <td class="col-10"></td>
                            <td class="col-2">
                                <a href="{{ route('administrator.add_product.show') }}" class="btn btn-orange">
                                    <span><i class="material-icons md-18">add</i></span>Tambah Produk
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    showAllProducts();
})

function showAllProducts() {
    $("#new-products").removeClass('product-toggle-active');
    $("#all-products").addClass('product-toggle-active');
    var $list = $("#product-list");
    var arg = 1;
    $.ajax({
        method: 'GET',
        data: { arg: arg },
        url: '/admin/fetch-products/' + arg,
        success: function(res) {
            console.log(res);
            $list.html(res.html);
        }
    });
}

function showNewProducts() {
    $("#all-products").removeClass('product-toggle-active');
    $("#new-products").addClass('product-toggle-active');
    var $list = $("#product-list");
    var arg = 2;
    $.ajax({
        method: 'GET',
        data: { arg: arg },
        url: '/admin/fetch-products/' + arg,
        success: function(res) {
            console.log(res);
            $list.html(res.html);
        }
    });
}
</script>
@endsection