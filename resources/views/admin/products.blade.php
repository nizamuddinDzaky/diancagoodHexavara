@extends('layouts.admin')

@section('title')
<title>Produk</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row pb-100">
        <div class="col-lg-12">
            <div class="table-responsive curved-border">
                <table class="table table-bordered text-gray-2">
                    <thead class="font-14">
                        <tr>
                            <th class="px-3 text-center">Produk</th>
                            <th class="px-3">Harga</th>
                            <th class="px-3">Stok</th>
                            <th class="px-3"></th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        @include('admin.products-list')
                    </tbody>
                    <tfoot>
                        <tr class="d-flex">
                            <td>
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