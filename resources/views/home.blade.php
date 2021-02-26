@extends('layouts.store')

@section('title')
<title>DiancaGoods</title>
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
    <hr class="pb-2" style="border-color:F2F2F2">
</div>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">           
            <div class="row my-2 pb-4 pt-4 pl-2">
                <div class="main_title">
                    <h2>Kategori apa yang kamu cari?</h2>
                </div>
            </div>
            <div class="row my-2">
                @forelse($category as $row)
                <div class="col">
                    <div class="f_p_item">
                        <div class="f_p_img pl-3">
                            <a href="{{ url('/category/' . $row->slug) }}">
                                <img id="pic{{ $row }}" class="home-product-center-cropped" src="{{ asset('storage/categories/' . $row->image) }}" alt="{{ $row->name }}">
                            </a>
                        </div>
                        <a href="{{ url('/category/' . $row->slug) }}" class="pl-3">
                            <h4 style="color: black">{{ $row->name }}</h4>
                        </a>
                    </div>
                </div>
                @empty

                @endforelse
            </div>
        </div>
    </div>
</section>
<div class="container">
    <hr class="pb-4" style="border-color:F2F2F2">
</div>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 pb-4 pt-4 pl-2">
                <div class="main_title">
                    <h2>Produk Baru</h2>
                </div>
            </div>
            <div class="row my-2">
                @forelse($newproducts as $row)
                <div class="col">
                    <div class="f_p_item">
                        <div class="f_p_img pl-3">
                            <a href="{{ url('/product/' . $row->id) }}">
                                <img id="pic{{ $row }}" class="home-product-center-cropped" src="{{ asset('storage/products/' . $row->images->first()->filename) }}" alt="{{ $row->name }}">
                            </a>
                        </div>
                        <a href="{{ url('/product/' . $row->id) }}">
                            <h4 class="text-gray-2" class="pl-3">{{ $row->name }}</h4>
                        </a>
                        @if( number_format($row->variant->first()->price) != number_format($row->variant->last()->price)
                        )
                        <h5 class="text-gray-1">Rp {{ number_format($row->variant->first()->price) }} - Rp
                            {{ number_format($row->variant->last()->price) }}</h5>
                        @else
                        <h5 class="text-gray-1">Rp {{ number_format($row->variant->first()->price) }}</h5>
                        @endif
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</section>
<div class="container">
    <hr class="pb-4" style="border-color:F2F2F2">
</div>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 pb-4 pt-4 pl-2">
                <div class="col-lg-6">
                    <div class="main_title">
                        <h3>Produk Terlaris</h3>
                    </div>
                    <div class="row py-2">
                        @forelse($bestseller as $row)
                        <div class="col-lg-12 pb-4">
                            <div class="card shadow-1">
                                <div class="row px-4 py-4">
                                    <div class="col-lg-4">
                                        <a href="{{ url('/product/' . $row->id) }}">
                                            <img id="pic{{ $row }}" class="product-img-sm" src="{{ asset('storage/products/' . $row->images->first()->filename) }}" alt="{{ $row->name }}">
                                        </a>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row ml-2 pt-3">
                                            <a href="{{ url('/product/' . $row->id) }}">
                                                <h4 class="text-gray-2">{{ $row->name }}</h4>
                                            </a>
                                        </div>
                                        <div class="row ml-2 pt-2">
                                        @if( number_format($row->variant->first()->price) != number_format($row->variant->last()->price))
                                        <h5 class="text-gray-2 weight-700 font-20">Rp {{ number_format($row->variant->first()->price) }} - Rp
                                            {{ number_format($row->variant->last()->price) }}</h5>
                                        @else
                                        <h5 class="text-gray-2 weight-700 font-20">Rp {{ number_format($row->variant->first()->price) }}</h5>
                                        @endif
                                        </div>
                                        <div class="row ml-2">
                                            <p>722 Terjual</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main_title">
                        <h3>Produk Pilihan</h3>
                    </div>
                    <div class="row py-2">
                        @forelse($featured as $row)
                        <div class="col-lg-12 pb-4">
                            <div class="card shadow-1">
                                <div class="row px-4 py-4">
                                    <div class="col-lg-4">
                                        <a href="{{ url('/product/' . $row->id) }}">
                                            <img id="pic{{ $row }}" class="product-img-sm" src="{{ asset('storage/products/' . $row->images->first()->filename) }}" alt="{{ $row->name }}">
                                        </a>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row ml-2 pt-3">
                                            <a href="{{ url('/product/' . $row->id) }}">
                                                <h4 style="color: black">{{ $row->name }}</h4>
                                            </a>
                                        </div>
                                        <div class="row ml-2 pt-2">
                                        @if( number_format($row->variant->first()->price) != number_format($row->variant->last()->price)
                                        )
                                        <h5 class="text-gray-2 weight-700 font-20">Rp {{ number_format($row->variant->first()->price) }} - Rp
                                            {{ number_format($row->variant->last()->price) }}</h5>
                                        @else
                                        <h5 class="text-gray-2 weight-700 font-20">Rp {{ number_format($row->variant->first()->price) }}</h5>
                                        @endif
                                        </div>
                                        <div class="row ml-2">
                                            <p>378 Terjual</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="feature_product_area section_gap testimoni">
    <div class="main_box">
        <div class="container">
            <div class="row my-2">
                <div class="main_title">
                    <h2>Testimoni</h2>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-4">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h4 class="weight-600">Testimoni 1</h4>
                            <p class="text-gray-3 font-14">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h4 class="weight-600">Testimoni 1</h4>
                            <p class="text-gray-3 font-14">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h4 class="weight-600">Testimoni 1</h4>
                            <p class="text-gray-3 font-14">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection