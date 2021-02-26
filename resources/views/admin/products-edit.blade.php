@extends('layouts.admin')

@section('title')
<title>Edit Produk</title>
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
                    <form method="POST" action="{{ route('administrator.update_product') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama Produk</label>
                                    <input type="text" name="name" class="form-control bg-light-2 no-border" value="{{ $product->name }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-label" for="category_id">Kategori Produk</label>
                                    <select id="category_id" name="category_id" class="form-control bg-light-2">
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
                                    <select id="brand_id" name="brand_id" class="form-control bg-light-2">
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
                                    <select id="subcategory_id" name="subcategory_id" class="form-control bg-light-2">
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
                                            <textarea name="description" class="form-control bg-light-2 no-border"
                                                rows="5" required>
                                                {{ $product->description ?? '' }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label class="form-label">Foto Produk</label>
                                <div class="images">
                                    <div class="pic" id="placeholder">Drag your image here, or browse</div>
                                    <input type="file" id="images" accept="image/*" name="images[]"
                                        style="visibility:hidden" multiple />
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-6">
                                <label class="form-label">Varian</label>
                                @include('admin.variants-list', ['variants' => 'product_variants'])
                                <button type="button" id="add-variant" class="btn btn-block btn-orange my-2 py-2">Tambah Varian</button>
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
                                    @foreach($product->images as $i)
                                    <div class="img" style="background-image: url(/storage/products/{{ $i->filename }})" rel="{{ asset('storage/products/' . $i->filename) }}">
                                        <span><strong>Hapus</strong></span>
                                    </div>
                                    
                                    @endforeach
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
@endsection

@section('js')
<script>
$(document).ready(function() {
    $("#category_id option[value=" + {{ $product->subcategory->category->id }} + "]").attr('selected', 'selected');
    $("#subcategory_id option[value=" + {{ $product->subcategory->id }} + "]").attr('selected', 'selected');
    $("#brand_id option[value=" + {{ $product->brand->id }} + "]").attr('selected', 'selected');

    var category_button = $('#category_placeholder');
    var category_uploader = $('#category_input');
    var category_images = $('#category_container');
    var product_button = $('.images .pic');
    var product_uploader = $('#images');
    var product_images = $('.images');

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
</script>
@endsection