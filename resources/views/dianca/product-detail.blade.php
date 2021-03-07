@extends('layouts.store')

@section('title')
    <title>{{ $product->name }}</title>
@endsection

@section('css')
<style>
    input[type='radio'] { display:none; }
    input[type='radio'] + label {
        display:inline-block;
        background-color:#fff;
        padding:5px 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        border-radius: 3px;
        border-color: #828282;
        color: #828282;
        cursor:pointer;
        transition: all 300ms linear 0s;
    }
    input[type='radio']:hover + label {
        background-color:#FDE0CE;
        color: #F37020;
    }
    input[type='radio']:checked + label {
        background-color:#FDE0CE;
        color: #F37020;
    }
</style>
@endsection

@section('content')
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner mb-4">
            <div class="col-lg-6">
                <div class="row justify-content-center pb-3">
                    <div class="s_product_img">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" id="display-product-image" src="{{ asset('storage/products/' . $product->images->first()->filename) }}"
                                        alt="{{ $product->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @foreach($product->images as $i)
                    <div class="gallery">
                        <img id="img{{ $i->id }}" class="product-image" src="{{ asset('storage/products/' . $i->filename) }}">
                    </div>
                    @endforeach
                    <div></div>
                </div>
            </div>
            <div class="col-lg-5 ml-4">
                <div class="s_product_text text-gray-3">
                    <h5>{{ $product->category->name }}</h5>
                    <h3>{{ $product->name }}</h3>
                    <p>
                        <span>Total Stok: <strong id="stock"></strong></span>
                        <span>Berat: <strong id="weight"></strong>gr</span>
                    </p>
                    <div class="row mb-2 ml-1">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h2>Rp {{ number_format($product->variant->first()->price, 2, ',', '.') }}</h2>
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <div class="product_variant">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h4>Varian</h4>
                                </div>                       
                                <div class="col-lg-8">
                                    @forelse($product->variant as $row)
                                    <input type="radio" name="btn_variant" id="var{{ $row->id }}" value="{{ $row->id }}">
                                    <label for="var{{ $row->id }}">{{ $row->name }}</label>
                                    @empty

                                    @endforelse
                                    <input type="hidden" name="product_variant_id" value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <h4>Atur jumlah</h4>
                                </div>                       
                                <div class="col-lg-8">
                                    <div class="input-group ml-4">
                                        <span class="product_count">
                                            <button class="reduced items-count" type="button" onclick="decrement()">
                                                <span class="material-icons">remove</span>
                                            </button>
                                        </span>
                                        <span class="product_count">
                                            <input type="text" name="qty" id="qty" maxlength="12" value="1" class="input-text" required>
                                        </span>
                                        <span class="product_count">
                                            <button class="increase items-count" type="button" onclick="increment()">
                                                <span class="material-icons">add</span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <h4>Pengiriman</h4>
                                </div>                       
                                <div class="col-lg-8">
                                    <div class="font-16 mb-2">
                                        Dikirim dari <strong>Jakarta Selatan</strong>
                                    </div>
                                    <div class="font-16 my-2">
                                        Tujuan pengiriman <strong>Sukolilo, Surabaya</strong>
                                    </div>
                                    <div class="font-16 my-2">
                                        Ongkos kirim mulai dari <strong>Rp 18.000</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <button class="btn btn-orange font-20 py-3 px-5 mr-2">+ Keranjang</button>
                                    <a id="quick-add" type="button" class="btn btn-outline-gray font-20 py-3 px-5">Beli Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row my-4">
            <div class="col-lg-12">
                <h4 class="text-gray-2 weight-600 font-24">Deskripsi</h4>
                <p class="text-gray-3 font-16" style="white-space: pre-wrap">
                    {{ $product->description }}
                </p>
            </div>
        </div>
        <hr/>
        <div class="row my-4">
            <div class="col-lg-12">
                <h4 class="text-gray-2 weight-600 font-24 pb-3">Ulasan</h4>
                <div class="row">
                    <div class="col-lg-1 md-1 sm-1 text-center">
                        <img src="/img/people.png" alt="ok" style="border-radius: 50%">
                    </div>
                    <div class="col-lg-3 md-3 sm-3">
                        <h5 class="weight-400">Rizal Adam</h5>
                        <p class="text-gray-3">Hari ini</p>
                    </div>
                    <div class="col-lg-8 md-8 sm-8">
                        <div class="row mb-2 ml-1">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <h5 class="text-gray-3 weight-400 ml-1">Barang udah sampe dan original, pacar juga seneng banget dibeliin ini</h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-1 md-1 sm-1 text-center">
                        <img src="/img/people.png" alt="ok" style="border-radius: 50%">
                    </div>
                    <div class="col-lg-3 md-3 sm-3">
                        <h5 class="weight-400">Bunga Putri</h5>
                        <p class="text-gray-3">Kemarin</p>
                    </div>
                    <div class="col-lg-8 md-8 sm-8">
                        <div class="row mb-2 ml-1">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                        </div>
                        <h5 class="text-gray-3 weight-400 ml-1">Kualitas Sangat Baik</h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-1 md-1 sm-1 text-center">
                        <img src="/img/people.png" alt="ok" style="border-radius: 50%">
                    </div>
                    <div class="col-lg-3 md-3 sm-3">
                        <h5 class="weight-400">Anggi Putri Dewi</h5>
                        <p class="text-gray-3">20 Desember 2020</p>
                    </div>
                    <div class="col-lg-8 md-8 sm-8">
                        <div class="row mb-2 ml-1">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        const firstVariant = {{ $product->variant->first()->id }};
        $("#var"+firstVariant).prop("checked", true).trigger("change");
    });

    $(document).ready(function() {
        $("#all-orders").addClass('filter-active');
    });

    const divs = document.querySelectorAll('.product-image');

    divs.forEach(el => el.addEventListener('click', e => {
        const display = e.target.getAttribute('src');
        $(".s_product_img").fadeOut('200', function() {
            $('#display-product-image').attr("src", display);
        }).fadeIn('200');
    }));

    function increment() {
        var input = document.getElementById('qty');
        input.value++;
        console.log($("#qty").val())
    }

    function decrement() {
        var input = document.getElementById('qty');
        if(input.value - 1 > 0){
            input.value--;
        }
    }

    $("input[name=btn_variant]").on('change', function(e) {
        e.preventDefault();
        $("input[name=product_variant_id]").val(this.value);
    });

    document.getElementById("quick-add").onclick = function(){
        document.getElementById("quick-add").href = "/cart/quick-add/" + $("input[name=product_variant_id]").val();
        $("#quick-add").click();
    }
</script>
@endsection