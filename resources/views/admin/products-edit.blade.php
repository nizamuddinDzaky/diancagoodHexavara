@extends('layouts.admin')

@section('title')
<title>Edit Produk</title>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card curved-border border-1">
                <div class="card-body py-5">
                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="row mt-2 mb-5">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-11">
                            <h4 class="weight-600 font-24">Informasi Produk</h4>
                        </div>
                    </div>
                    <form method="POST" id="update-product" action="{{ route('administrator.update_product') }}" enctype="multipart/form-data">
                        @csrf
                        <div style="display:none" id="variant">
                            
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama Produk</label>
                                    <input type="text" name="name" class="form-control bg-light-2 no-border" value="{{ $product->name }}" required>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-label" for="category_id">Kategori Produk</label>
                                    <select id="category_id" name="category_id" class="form-control bg-light-2 selector">
                                        <option value="">Pilih</option>
                                        @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                        <option value="new">Tambah</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-label" for="brand_id">Brand</label>
                                    <select id="brand_id" name="brand_id" class="form-control bg-light-2 selector">
                                        <option value="">Pilih</option>
                                        @foreach($brands as $b)
                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                        @endforeach
                                        <option value="new">Tambah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-label" for="subcategory_id">Subkategori</label>
                                    <select id="subcategory_id" name="subcategory_id" class="form-control bg-light-2 selector">
                                        <option value="">Pilih</option>
                                        @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                        <option value="new">Tambah</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-6">
                                <div class="row mt-2">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label" for="rate">Rate</label>
                                            <input type="text" name="rate" class="form-control bg-light-2 no-border" value="{{ $product->rate }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Deskripsi</label>
                                            <textarea name="description" class="form-control bg-light-2 no-border" rows="5" required>{{ $product->description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <label class="form-label">Varian</label>
                                        @include('admin.variants-list', ['variants' => 'product_variants'])
                                        <button type="button" id="add-variant" class="btn btn-block btn-orange my-2 py-2">Tambah Varian</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label class="form-label">Foto Produk</label>
                                <div class="images image_product" id="product_container">
                                    <div class="pic" id="product_placeholder">Drag your image here, or browse</div>
                                    <input type="file" id="product_input" accept="image/*" name="image_product[]"
                                        style="visibility:hidden" multiple />
                                    @forelse($product->images as $i)
                                    <div class="img">
                                        <img class="img" src="{{ asset('/storage/products/' . $i->filename) }}">
                                        <span><strong>Hapus</strong></span>
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-7"></div>
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-orange float-right font-16 px-5 py-2 mr-0">Submit &
                                    Publish</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="modal_category" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('administrator.add_category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute text-gray-2 weight-600">Tambah Kategori
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-2">
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama Kategori</label>
                                    <input type="text" name="name" class="form-control bg-light-2 no-border" required
                                        autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label">Foto Kategori</label>
                                <div class="images image_category" id="category_container">
                                    <div class="pic" id="category_placeholder">Drag your image here, or browse</div>
                                    <input type="file" id="category_input" accept="image/*" name="image_category"
                                        style="display:none" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gray" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-orange">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="modal_subcategory" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('administrator.add_subcategory') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute text-gray-2 weight-600">Tambah Subkategori
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-2">
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama Kategori</label>
                                    <input type="text" name="popup_category_name" value="" class="form-control bg-light-2 no-border" required disabled>
                                    <input type="hidden" name="popup_category_id" value="" class="form-control bg-light-2 no-border" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-10">
                                <label class="form-label">Nama Subkategori</label>
                                <input type="text" name="name" class="form-control bg-light-2 no-border" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gray" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-orange">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="modal_brand" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('administrator.add_brand') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute text-gray-2 weight-600">Tambah Brand
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-2">
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama Brand</label>
                                    <input type="text" name="name" class="form-control bg-light-2 no-border" required
                                        autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gray" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-orange">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="modal_variant" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('administrator.add_variant', ['product_id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute text-gray-2 weight-600">Tambah Varian
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama Varian</label>
                                    <input type="text" name="name" class="form-control bg-light-2 no-border" required
                                        autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <label class="form-label">Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-3 border-3">Rp</div>
                                    </div>
                                    <input type="text" name="price" class="form-control border-3">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Berat</label>
                                <div class="input-group">
                                    <input type="text" name="weight" class="form-control border-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text bg-3 border-3">gr</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Stok</label>
                                <input type="text" name="stock" class="form-control bg-light-2 no-border" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label">Foto Kategori</label>
                                <div class="images image_variant" id="variant_container">
                                    <div class="pic" id="variant_placeholder">Drag your image here, or browse</div>
                                    <input type="file" id="variant_input" accept="image/*" name="image_variant"
                                        style="display:none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gray" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-orange">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="detail_variant" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute text-gray-2 weight-600">Detail Varian
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="table-responsive curved-border">
                                <table class="table table-bordered text-gray-2">
                                    <tbody>
                                        <tr class="d-flex">
                                            <th class="col-4">Nama Varian</th>
                                            <td class="col-8" id="detail-name"></td>
                                        </tr>
                                        <tr class="d-flex">
                                            <th class="col-4">Stok</th>
                                            <td class="col-8" id="detail-stock"></td>
                                        </tr>
                                        <tr class="d-flex">
                                            <th class="col-4">Berat</th>
                                            <td class="col-8" id="detail-weight"></td>
                                        </tr>
                                        <tr class="d-flex">
                                            <th class="col-4">Harga</th>
                                            <td class="col-8" id="detail-price"></td>
                                        </tr>
                                        <tr class="d-flex">
                                            <th class="col-4">Foto</th>
                                            <td class="col-8" id="detail-image"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-gray" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade w-100" id="edit_variant" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form id="form-edit-variant">
                @csrf
                <input type="hidden" name="product_id" id="edit_product_id">
                <input type="hidden" name="variant_id" id="edit_variant_id">
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute text-gray-2 weight-600">Edit Varian</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama Varian</label>
                                    <input type="text" name="name" id="edit-name" class="form-control bg-light-2 no-border" required
                                        autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <label class="form-label">Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-3 border-3">Rp</div>
                                    </div>
                                    <input type="text" name="price" id="edit-price" class="form-control border-3">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Berat</label>
                                <div class="input-group">
                                    <input type="text" name="weight" id="edit-weight" class="form-control border-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text bg-3 border-3">gr</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Stok</label>
                                <input type="text" name="stock" id="edit-stock" class="form-control bg-light-2 no-border" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label">Foto Varian</label>
                                <div class="images image_variant" id="edit_variant_container">
                                    <div class="pic" id="edit_variant_placeholder">Drag your image here, or browse
                                    </div>
                                    <input type="file" id="edit_variant_input" accept="image/*" name="image"
                                        style="display:none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gray" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-orange" id="add-variant-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(".selector").select2({
        width: '100%',
        theme: 'bootstrap'
    });
    
    $('#category_id>option[value="' + {{ $product->category_id }} + '"]').prop('selected', true);
    $('#subcategory_id>option[value="' + {{ $product->subcategory_id }} + '"]').prop('selected', true);
    $('#brand_id>option[value="' + {{ $product->brand_id }} + '"]').prop('selected', true);

    var variants = $("#variant");
    
    var category_button = $('#category_placeholder');
    var category_uploader = $('#category_input');
    var category_images = $('#category_container');
    var product_button = $('#product_placeholder');
    var product_uploader = $('#product_input');
    var product_images = $('#product_container');
    var variant_button = $('#variant_placeholder');
    var variant_uploader = $('#variant_input');
    var variant_images = $('#variant_container');
    var edit_variant_button = $('#edit_variant_placeholder');
    var edit_variant_uploader = $('#edit_variant_input');
    var edit_variant_images = $('#edit_variant_container');

    category_button.on('click', function() {
        category_uploader.click();
    });

    category_uploader.on('change', function() {
        $('#img_category').remove();

        var reader = new FileReader();
        var data = $(this)[0].files;

        $.each(data, function(index, file) {
            if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
                var reader = new FileReader();
                reader.onload = (function(file) {
                    return function(e) {
                        var img = $(
                            '<div class="img" id="img_category" style="background-image: url(\'' +
                            e
                            .target.result +
                            '\');" rel="' + e.target.result +
                            '"><span><strong>Hapus</strong></span></div>');
                        category_images.append(img);
                    };
                })(file);
                reader.readAsDataURL(file);
            }
        });
    });

    category_images.on('click', '.img', function() {
        $(this).remove();
    })

    product_button.on('click', function() {
        product_uploader.click();
    });

    product_uploader.on('change', function() {
        var reader = new FileReader();
        var data = $(this)[0].files;

        $.each(data, function(index, file) {
            if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
                var reader = new FileReader();
                reader.onload = (function(file) {
                    return function(e) {
                        var img = $('<div class="img" style="background-image: url(\'' + e
                            .target.result +
                            '\');" rel="' + e.target.result +
                            '"><span><strong>Hapus</strong></span></div>');
                        product_images.append(img);
                    };
                })(file);
                reader.readAsDataURL(file);
            }
        });
    });

    product_images.on('click', '.img', function() {
        $(this).remove();
    })

// Upload variant images
variant_button.on('click', function() {
    variant_uploader.click();
});

variant_uploader.on('change', function() {
    console.log(variant_uploader.val());
    $('#img_variant').remove();

    // var reader = new FileReader();
    var data = $(this)[0].files;

    $.each(data, function(index, file) {
        if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
            var reader = new FileReader();
            reader.onload = (function(file) {
                return function(e) {
                    var img = $(
                        '<div class="img" id="img_variant" style="background-image: url(\'' +
                        e
                        .target.result +
                        '\');" rel="' + e.target.result +
                        '"><span><strong>Hapus</strong></span></div>'
                    );
                    variant_images.append(img);
                };
            })(file);
            reader.readAsDataURL(file);
        }
    });
});

variant_images.on('click', '.img', function() {
    $(this).remove();
})

// Upload variant images
edit_variant_button.on('click', function() {
    edit_variant_uploader.click();
});

edit_variant_uploader.on('change', function() {
    console.log(edit_variant_uploader.val());
    $('#edit_img_variant').remove();

    // var reader = new FileReader();
    var data = $(this)[0].files;

    $.each(data, function(index, file) {
        if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
            var reader = new FileReader();
            reader.onload = (function(file) {
                return function(e) {
                    var img = $(
                        '<div class="img" id="edit_img_variant" style="background-image: url(\'' +
                        e.target.result +
                        '\');" rel="' + e.target.result +
                        '"><span><strong>Hapus</strong></span></div>'
                    );
                    edit_variant_images.append(img);
                };
            })(file);
            reader.readAsDataURL(file);
        }
    });
});

edit_variant_images.on('click', '.img', function() {
    $(this).remove();
})

$("#category_id").on('change', function() {
    $.ajax({
        url: "{{ url('/admin/subcategories-fetch') }}",
        type: 'GET',
        data: {
            category_id: $(this).val()
        },
        success: function(res) {
            $("#subcategory_id").empty();
            $('#subcategory_id').append('<option value="">Pilih</option>')
            $.each(res.data, function(key, item) {
                $("#subcategory_id").append('<option value="' + item.id + '">' + item.name + '</option>');
            });
            $("#subcategory_id").append('<option value="new">Tambah</option>');
        },
    });
});

$('select[name=category_id]').change(function() {
    if ($(this).val() == 'new') {
        $('#modal_category').modal('show');
    }
});

$('select[name=subcategory_id]').change(function() {
    if ($(this).val() == 'new') {
        var category_id = $("#category_id").val();
        var category = $("#category_id option:selected").text();
        $('input[name=popup_category_name]').val(category);
        $('input[name=popup_category_id]').val(category_id);
        console.log($('input[name=popup_category_id]').val());
        $('#modal_subcategory').modal('show');
    }
});

$('select[name=brand_id]').change(function() {
    if ($(this).val() == 'new') {
        $('#modal_brand').modal('show');
    }
});

$("#add-variant").on('click', function() {
    $('#modal_variant').modal('show');
})

$("form#form-variant").submit(function(e) {
    e.preventDefault();
    const data = new FormData(this);
    $.ajax({
        "_token": "{{ csrf_token() }}",
        url: "add-variant",
        type: 'POST',
        data: data,
        enctype: 'multipart/form-data',
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        success: function(res) {
            console.log(res);
            const variant = $('<tr class="d-flex"><td class="col-4">' + res.name +
                '</td><td class="col-2">' + res.price +
                '</td><td class="col-6"><button type="button" class="btn btn-orange show-variant" onclick="showDetail(' +res.id + ')">Detail</button></td></tr>'
                )
            variants.append(`
                <input type="hidden" name="variants[]" value=` + res.id +`>
            `);
            $("#variants-list").append(variant);

            $('#modal_variant').modal('hide');
        },
        error: function(xhr, status, err) {
            console.log(xhr.responseText);
        }
    });
})

function showDetail(id) {
    var variant_id = id;
    $("#detail_variant").modal('show');

    $.ajax({
        url: "/product-variant/" + variant_id,
        type: "GET",
        dataType: "JSON",
        success: function(res){
            $("#detail-name").html(res.name);
            $("#detail-stock").html(res.stock);
            $("#detail-weight").html(res.weight + " gr");
            $("#detail-price").html(res.price.toLocaleString("id-ID", { style: "currency", currency: "IDR"}));
            var path = 'storage/variants/' + res.image;
            $("#detail-image").html(`<img class="w-100" src="{{ asset('` + path + `') }}">`);
        }
    })
}

function editVariant(id) {
    $("#edit_variant").modal('show');
    $("#edit_img_variant").remove();
    
    $.ajax({
        url: "/product-variant/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(res){
            $("#edit-name").val(res.name);
            $("#edit-stock").val(res.stock);
            $("#edit-weight").val(res.weight);
            $("#edit-price").val(res.price);
            $("#edit_product_id").val(res.product_id);
            $("#edit_variant_id").val(res.id);
            var path = '/storage/products/' + res.image;
            var img = $(
                        '<div class="img" id="edit_img_variant" style="background-image: url(\'' +
                        path + '\');" rel="' + path +
                        '"><span><strong>Hapus</strong></span></div>'
                    );
            edit_variant_images.append(img);
        }
    })
}

function deleteVariant(id) {
    console.log(id);
    Swal.fire({
        title: "Hapus varian?",
        text: "Anda akan menghapus varian",
        icon: "warning",
        reverseButtons: !0
    }).then(function (e) {
        var data = new FormData();
        data.append('id', id);

        $.ajax({
            url: "/product-variant/delete/" + id,
            type: "POST",
            data: {
                '_method': 'DELETE',
                "_token": "{{ csrf_token() }}",
            },
            success: function(res) {
                $("#edit_variant").modal('hide');
                $("#rowvar"+id).remove();
            },
            error: function(xhr, status, err) {
                console.log(xhr.responseText);
            },
        })
        e.dismiss;
    }, function (dismiss) {
        return false;
    })
}
</script>
@endsection