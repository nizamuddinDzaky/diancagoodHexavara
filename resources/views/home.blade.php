@extends('layouts.store')

@section('title')
<title>DiancaGoods</title>
@endsection

@section('css')
@endsection

@section('content')
<section class="feature_product_area section_gap mt-4">
    <div class="main_box">
        <div class="container">
            <div class="row py-4">
                <div class="f_p_img">
                    <img class="hero" src="{{ asset('img/hero-2x.png') }}">
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <hr class="pb-4" style="border-color:F2F2F2">
</div>
<section class="feature_product_area section_gap">
    <div class="main_box">
        <div class="container">           
            <div class="row my-2">
                <div class="main_title">
                    <h2>Kategori apa yang kamu cari?</h2>
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <div class="f_p_item">
                        <div class="f_p_img">
                            <a href="#">
                                <img id="image" class="home-product-center-cropped" src="{{ asset('img/A1.jpg') }}" alt="kategori">
                            </a>
                        </div>
                        <h4>Nama Kategori</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <hr class="pb-4" style="border-color:F2F2F2">
</div>
<section class="feature_product_area section_gap">
    <div class="main_box">
        <div class="container">
            <div class="row my-2">
                <div class="main_title">
                    <h2>Produk Baru</h2>
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <div class="f_p_item">
                        <div class="f_p_img">
                            <a href="#">
                                <img id="image" class="home-product-center-cropped" src="img/A1.jpg" alt="kategori">
                            </a>
                        </div>
                        <h4>Nama Produk Baru</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <hr class="pb-4" style="border-color:F2F2F2">
</div>
<section class="feature_product_area section_gap">
    <div class="main_box">
        <div class="container">
            <div class="row my-2">
                <div class="col-lg-6">
                    <div class="main_title">
                        <h3>Produk Terlaris</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main_title">
                        <h3>Produk Pilihan</h3>
                    </div>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-lg-6">
                    <div class="row py-2">
                        <div class="col-lg-12">
                            <div class="card shadow-1" style="width: 32rem">
                                <div class="row px-4 py-4">
                                    <div class="col-lg-4">
                                        <img class="product-img-sm" src="{{ asset('img/starter.png') }}">
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row ml-2 pt-3">
                                            <h4>AXIS-Y Mugwort Pore Clarifying Wash Off Pack 100 ml</h4>
                                        </div>
                                        <div class="row ml-2 pt-2">
                                            <h3><strong>Rp 299.000</strong></h3>
                                        </div>
                                        <div class="row ml-2">
                                            <p>722 Terjual</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row py-2">
                        <div class="col-lg-12">
                            <div class="card shadow-1" style="width: 32rem">
                                <div class="row px-4 py-4">
                                    <div class="col-lg-4">
                                        <img class="product-img-sm" src="{{ asset('img/starter.png') }}">
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row ml-2 pt-3">
                                            <h4>SOMETHINC Niacinamide + Moisture Beet Serum</h4>
                                        </div>
                                        <div class="row ml-2 pt-2">
                                            <h3><strong>Rp 149.000</strong></h3>
                                        </div>
                                        <div class="row ml-2">
                                            <p>378 Terjual</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="feature_product_area section_gap">
    <div class="main_box">
        <div class="container">
            <div class="row my-2">
                <div class="main_title">
                    <h2>Testimoni</h2>
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <div class="f_p_item">
                        <div class="f_p_img">
                            <a href="#">
                                <img id="image" class="home-product-center-cropped" src="img/A1.jpg" alt="kategori">
                            </a>
                        </div>
                        <h4>Testimoni 1</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@endsection