@extends('layouts.store')

@section('title')
<title>DiancaGoods</title>
@endsection

@section('content')
<section class="feature_product_area section_gap pb-3 mt-4">
    <div class="main_box">
        <div class="container">
            <div class="row py-4">
                <img class="hero" src="{{ asset('img/hero-2x.png') }}">
            </div>
            <hr class="py-2" style="border-color:F2F2F2">
        </div>
    </div>
</section>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 py-4 pl-2">
                <div class="main_title">
                    <h2>Kategori apa yang kamu cari?</h2>
                </div>
            </div>
            <div class="row my-2 justify-content-center">
                @forelse($category as $row)
                <div class="col">
                    <div class="f_p_item_category">
                        <div class="f_p_img">
                            <a href="{{ url('/category/' . $row->id) }}">
                                <img id="pic{{ $row }}" class="home-category-center-cropped" src="{{ asset('storage/categories/' . $row->image) }}" alt="{{ $row->name }}">
                            </a>
                        </div>
                        <a href="{{ url('/category/' . $row->id) }}" class="pl-3">
                            <h4 style="color: black">{{ $row->name }}</h4>
                        </a>
                    </div>
                </div>
                @empty

                @endforelse
            </div>
            <hr class="py-2" style="border-color:F2F2F2">
        </div>
    </div>
</section>
@forelse($promos as $p)
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 py-4 pl-2">
                <div class="main_title">
                    <h2>{{ $p->name }}</h2>
                </div>
            </div>
            <div class="row my-2">
                @forelse($p->details as $pd)
                <div class="col-lg-3">
                    <div class="f_p_item">
                        <div class="f_p_img">
                            <a href="{{ url('/product/'. $pd->variant->product->id) }}">
                                <img class="promo-product" src="{{ asset('storage/products/' . $pd->variant->product->images->first()->filename) }}" alt="{{ $pd->variant->product->name }}">
                            </a>
                        </div>
                        <a href="{{ url('/product/'. $pd->variant->product->id) }}">
                            <h4 class="text-gray-2" class="pl-3">{{ $pd->variant->product->name }} {{ $pd->variant->name }}</h4>
                        </a>
                        <h5 class="text-gray-1">Rp {{ number_format(($pd->variant->price - $pd->variant->promo_price), 2, ',', '.') }}</h5><span class="badge badge-primary badge-pill ml-2" style="vertical-align:top">DISKON {{ number_format($pd->variant->promo_price, 2, ',', '.') }}</span>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</section>
@empty
@endforelse
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 py-4 pl-2">
                <div class="main_title">
                    <h2>Produk Baru</h2>
                </div>
            </div>
            <div class="row my-2">
                @forelse($newproducts as $row)
                <div class="col-lg-3">
                    <div class="f_p_item">
                        <div class="f_p_img">
                            <a href="{{ url('/product/' . $row->id) }}">
                                <img class="home-product-center-cropped"
                                    src="{{ asset('storage/products/' . $row->images->first()->filename) }}"
                                    alt="{{ $row->name }}">
                            </a>
                        </div>
                        <a href="{{ url('/product/' . $row->id) }}">
                            <h4 class="text-gray-2" class="pl-3">{{ $row->name }}</h4>
                        </a>
                        @if($row->variant->first()->promo_price == 0)
                        <h5 class="text-gray-1">Rp {{ number_format($row->variant->first()->price) }}</h5>
                        @else
                        <h5 class="text-gray-1">Rp
                            {{ number_format($row->variant->first()->price - $row->variant->first()->promo_price) }}<span
                                class="d-inline-flex align-self-center ml-2"
                                style="text-decoration:line-through;"><small>Rp
                                    {{ number_format($row->variant->first()->price) }}</small></h5>
                        @endif
                        <h6>
                            @for($i = 0; $i < 5; $i++) @if ($i < $row->rate)
                                <span class="fa fa-star checked d-inline-flex align-self-end"></span>
                                @else
                                <span class="fa fa-star"></span>
                                @endif
                                @endfor
                        </h6>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
            <hr class="pb-4" style="border-color:F2F2F2">
        </div>
    </div>
</section>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 py-4 pl-2">
                <div class="col-lg-6">
                    <div class="main_title">
                        <h3>Produk Terlaris</h3>
                    </div>
                    <div class="row py-2">
                        @forelse($bestseller as $row)
                        <div class="col-lg-12 pb-4">
                            <div class="card bestseller-card">
                                <div class="row px-4 py-4">
                                    <div class="col-lg-4">
                                        <a href="{{ url('/product/' . $row->id) }}">
                                            <img class="product-img-sm"
                                                src="{{ asset('storage/products/' . $row->images->first()->filename) }}"
                                                alt="{{ $row->name }}">
                                        </a>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row ml-2 pt-3">
                                            <a href="{{ url('/product/' . $row->id) }}">
                                                <h4 class="text-gray-2">{{ $row->name }}</h4>
                                            </a>
                                        </div>
                                        <div class="row ml-2 pt-2">
                                            @if( number_format($row->variant->first()->price) !=
                                            number_format($row->variant->last()->price))
                                            <h5 class="text-gray-2 weight-700 font-20">Rp
                                                {{ number_format($row->variant->first()->price) }} - Rp
                                                {{ number_format($row->variant->last()->price) }}</h5>
                                            @else
                                            <h5 class="text-gray-2 weight-700 font-20">Rp
                                                {{ number_format($row->variant->first()->price) }}</h5>
                                            @endif
                                        </div>
                                        <div class="row ml-2 mb-2">
                                            @for($i = 0; $i < 5; $i++) @if ($i < $row->rate)
                                                <span class="fa fa-star checked"></span>
                                                @else
                                                <span class="fa fa-star"></span>
                                                @endif
                                                @endfor
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
                            <div class="card bestseller-card">
                                <div class="row px-4 py-4">
                                    <div class="col-lg-4">
                                        <a href="{{ url('/product/' . $row->id) }}">
                                            <img class="product-img-sm"
                                                src="{{ asset('storage/products/' . $row->images->first()->filename) }}"
                                                alt="{{ $row->name }}">
                                        </a>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row ml-2 pt-3">
                                            <a href="{{ url('/product/' . $row->id) }}">
                                                <h4 style="color: black">{{ $row->name }}</h4>
                                            </a>
                                        </div>
                                        <div class="row ml-2 pt-2">
                                            @if( number_format($row->variant->first()->price) !=
                                            number_format($row->variant->last()->price)
                                            )
                                            <h5 class="text-gray-2 weight-700 font-20">Rp
                                                {{ number_format($row->variant->first()->price) }} - Rp
                                                {{ number_format($row->variant->last()->price) }}</h5>
                                            @else
                                            <h5 class="text-gray-2 weight-700 font-20">Rp
                                                {{ number_format($row->variant->first()->price) }}</h5>
                                            @endif
                                        </div>
                                        <div class="row ml-2 mb-2">
                                            @for($i = 0; $i < 5; $i++) @if ($i < $row->rate)
                                                <span class="fa fa-star checked"></span>
                                                @else
                                                <span class="fa fa-star"></span>
                                                @endif
                                                @endfor
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
                <div class="col-lg-4 pb-4">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h4 class="weight-600">Testimoni 1</h4>
                            <p class="text-gray-3 font-14">Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
                                the 1500s,</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pb-4">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h4 class="weight-600">Testimoni 1</h4>
                            <p class="text-gray-3 font-14">Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
                                the 1500s,</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pb-4">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h4 class="weight-600">Testimoni 1</h4>
                            <p class="text-gray-3 font-14">Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
                                the 1500s,</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection