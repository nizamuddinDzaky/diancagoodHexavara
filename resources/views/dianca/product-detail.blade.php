@extends('layouts.store')

@section('title')
    <title>Pembelian</title>
@endsection

@section('css')
<style>
    input[type='radio'] { display:none; }
    input[type='radio'] + label {
        display:inline-block;
        background-color:#92acff;
        padding:5px 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        border-radius: 3px;
        color: white;
        cursor:pointer;
        transition: all 300ms linear 0s; }
        input[type='radio']:hover + label {
            background-color:#3d64e6;
        }
        input[type='radio']:checked + label {
            background-color:#3d64e6;
        }
</style>
@endsection

@section('content')
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner mb-4">
            <div class="col-lg-6">
                <div class="row">
                    <div class="s_product_img">
                        <img class="slider-center-cropped" src="{{ asset('storage/products/' . $product->image) }}">
                    </div>
                </div>
                
                <div class="row">
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
                    <p class="mb-1">stars</p>
                    <h2>Rp {{ number_format(248000, 2, ',', '.') }}</h2>
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <h4>Atur jumlah</h4>
                            </div>                       
                            <div class="col-lg-8">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <h4>Pengiriman</h4>
                            </div>                       
                            <div class="col-lg-8">
                                <div class="font-18 mb-2">
                                    Dikirim dari <strong>Jakarta Selatan</strong>
                                </div>
                                <div class="font-18 my-2">
                                    Tujuan pengiriman <strong>Sukolilo, Surabaya</strong>
                                </div>
                                <div class="font-18 my-2">
                                    Ongkos kirim mulai dari <strong>Rp 18.000</strong>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <button class="btn btn-orange font-20">+ Keranjang</button>
                                <button class="btn btn-outline-gray font-20">Beli Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row my-4">
            <div class="col-lg-12">
                <h4 class="text-gray-2 weight-600 font-24">Deskripsi</h4>
                <p class="text-gray-3 font-18">
                    {{ $product->description }}
                </p>
            </div>
        </div>
        <hr/>
        <div class="row my-4">
            <div class="col-lg-12">
                <h4 class="text-gray-2 weight-600 font-24">Ulasan</h4>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $("#all-orders").addClass('filter-active');
    });
</script>
@endsection