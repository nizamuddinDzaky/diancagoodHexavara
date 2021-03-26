@extends('layouts.store')

@section('title')
<title>DiancaGoods</title>
@endsection

@section('content')
<section class="feature_product_area mt-4 pt-4">
    <div class="main_box">
        <div class="mt-4">
            <div class="container">
                <img class="hero" src="{{ asset('img/hero-2x.png') }}">
                <hr style="border-color:F2F2F2">
            </div>
        </div>
    </div>
</section>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 py-2 pl-2">
                <div class="main_title">
                    <h2>Kategori apa yang kamu cari?</h2>
                </div>
            </div>
            <div class="row my-2 justify-content-center">
                @forelse($category as $row)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="f_p_item_category">
                        <div class="f_p_img">
                            <a href="{{ url('/category/' . $row->id) }}">
                                <img id="pic{{ $row }}" class="home-category-center-cropped" src="{{ asset('storage/categories/' . $row->image) }}" alt="{{ $row->name }}">
                            </a>
                        </div>
                        <a href="{{ url('/category/' . $row->id) }}" class="pl-3">
                            <h4 class="weight-600 text-gray-2">{{ $row->name }}</h4>
                        </a>
                    </div>
                </div>
                @empty

                @endforelse
            </div>
            <hr style="border-color:F2F2F2">
        </div>
    </div>
</section>
@forelse($promos as $p)
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 py-2 pl-2">
                <div class="main_title">
                    <h2>{{ $p->name }}</h2>
                </div>
            </div>
            <div class="row my-2">
                @forelse($p->details as $pd)
                <div class="col">
                    <div class="f_p_item">
                        <div class="f_p_img">
                            <a href="{{ url('/product/'. $pd->variant->product->id) }}">
                                <img class="promo-product" src="{{ asset('storage/products/' . $pd->variant->product->images->first()->filename) }}" alt="{{ $pd->variant->product->name }}">
                            </a>
                            <div class="p_icon">
                                <button onclick="addToCart({{ $pd->variant->first()->id }})"
                                    class="btn btn-orange ml-2 mt-2 text-center mb-2" style="">+
                                    Keranjang</button>
                            </div>
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
            <div class="row my-2 py-2 pl-2">
                <div class="main_title">
                    <h2>Produk Baru</h2>
                </div>
            </div>
            <div class="row my-2">
                @forelse($newproducts as $row)
                <div class="col">
                    <div class="f_p_item">
                        <div class="f_p_img">
                            <a href="{{ url('/product/' . $row->id) }}">
                                <img class="home-product-center-cropped"
                                    src="{{ asset('storage/products/' . $row->images->first()->filename) }}"
                                    alt="{{ $row->name }}">
                            </a>
                            <div class="p_icon">
                                <button onclick="addToCart({{ $row->variant->first()->id }})"
                                    class="btn btn-orange ml-2 mt-2 text-center mb-2" style="">+
                                    Keranjang</button>
                            </div>
                        </div>
                        <a href="{{ url('/product/' . $row->id) }}">
                            <h4 class="text-gray-2" class="pl-3">{{ $row->name }}</h4>
                        </a>
                        @if($row->variant->all() != NULL)
                        @if($row->variant->first()->promo_price == 0)
                        <h5 class="text-gray-1">Rp {{ number_format($row->variant->first()->price) }}</h5>
                        @else
                        <h5 class="text-gray-1">Rp
                            {{ number_format($row->variant->first()->price - $row->variant->first()->promo_price) }}<span
                                class="d-inline-flex align-self-center ml-2"
                                style="text-decoration:line-through;"><small>Rp
                                    {{ number_format($row->variant->first()->price) }}</small></h5>
                        @endif
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
            <hr style="border-color:F2F2F2">
        </div>
    </div>
</section>
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row my-2 py-2 pl-2">
                <div class="col-lg-6">
                    <div class="main_title">
                        <h2 class="text-lg-left text-center">Produk Terlaris</h2>
                    </div>
                    <div class="row py-2">
                        @forelse($bestseller as $row)
                        <div class="col-lg-12 pb-4">
                            <div class="card bestseller-card">
                                <div class="row px-3 py-3">
                                    <div class="col-lg-4 col-4">
                                        <a href="{{ url('/product/' . $row->id) }}">
                                            <img class="product-img-sm"
                                                src="{{ asset('storage/products/' . $row->images->first()->filename) }}"
                                                alt="{{ $row->name }}">
                                        </a>
                                    </div>
                                    <div class="col-lg-7 col-8">
                                        <div class="row ml-2">
                                            <a href="{{ url('/product/' . $row->id) }}">
                                                <h4 class="text-gray-2">{{ $row->name }}</h4>
                                            </a>
                                        </div>
                                        <div class="row ml-2 pt-1">
                                            @if($row->variant->all() != NULL)
                                            @if( number_format($row->variant->first()->price) !=
                                            number_format($row->variant->last()->price))
                                            <h5 class="text-gray-2 weight-700">Rp
                                                {{ number_format($row->variant->first()->price) }} - Rp
                                                {{ number_format($row->variant->last()->price) }}</h5>
                                            @else
                                            <h5 class="text-gray-2 weight-700">Rp
                                                {{ number_format($row->variant->first()->price) }}</h5>
                                            @endif
                                            @endif
                                        </div>
                                        <div class="row ml-2 pt-1 mb-2">
                                            @for($i = 0; $i < 5; $i++) @if ($i < $row->rate)
                                                <span class="fa fa-star checked"></span>
                                                @else
                                                <span class="fa fa-star"></span>
                                                @endif
                                                @endfor
                                        </div>
                                        <div class="row pt-1 ml-2">
                                            <p>722 Terjual</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                    <hr class="clearfix w-100 d-md-none pb-3">
                </div>
                <div class="col-lg-6">
                    <div class="main_title">
                        <h2 class="text-lg-left text-center">Produk Pilihan</h2>
                    </div>
                    <div class="row py-2">
                        @forelse($featured as $row)
                        <div class="col-lg-12 pb-4">
                            <div class="card bestseller-card">
                                <div class="row px-3 py-3">
                                    <div class="col-lg-4 col-4">
                                        <a href="{{ url('/product/' . $row->id) }}">
                                            <img class="product-img-sm"
                                                src="{{ asset('storage/products/' . $row->images->first()->filename) }}"
                                                alt="{{ $row->name }}">
                                        </a>
                                    </div>
                                    <div class="col-lg-7 col-8">
                                        <div class="row ml-2">
                                            <a href="{{ url('/product/' . $row->id) }}">
                                                <h4 style="color: black">{{ $row->name }}</h4>
                                            </a>
                                        </div>
                                        <div class="row ml-2 pt-1">
                                        @if($row->variant->all() != NULL)
                                            @if( number_format($row->variant->first()->price) !=
                                            number_format($row->variant->last()->price)
                                            )
                                            <h5 class="text-gray-2 weight-700">Rp
                                                {{ number_format($row->variant->first()->price) }} - Rp
                                                {{ number_format($row->variant->last()->price) }}</h5>
                                            @else
                                            <h5 class="text-gray-2 weight-700">Rp
                                                {{ number_format($row->variant->first()->price) }}</h5>
                                            @endif
                                        @endif
                                        </div>
                                        <div class="row ml-2 pt-1 mb-2">
                                            @for($i = 0; $i < 5; $i++) @if ($i < $row->rate)
                                                <span class="fa fa-star checked"></span>
                                                @else
                                                <span class="fa fa-star"></span>
                                                @endif
                                                @endfor
                                        </div>
                                        <div class="row pt-1 ml-2">
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
        <div class="container-fluid">
            <div class="row my-2">
                <div class="main_title">
                    <h2>Testimoni</h2>
                </div>
            </div>
            <div class="row my-2" style="display: flex;overflow-x: auto;overflow-y: hidden;max-height:300px">
            @forelse($reviews as $row)
                <div class="col">
                    <div class="f_p_item_testimoni" style="background: #FFFFFF;">
                        <div class="row">
                            <div class="col-lg-4 col-4 mb-2 pl-4">
                                <a href="{{ url('/product/' . $row->product->id) }}">
                                    <img class="img-testimoni pt-2"
                                        src="{{ asset('storage/products/' . $row->product->images->first()->filename) }}"
                                        alt="{{ $row->name }}" style="height:75px; width:75px">
                                </a>
                            </div>
                            <div class="col-lg-8 col-8 mt-2 pl-4 pr-4">
                                <a href="{{ url('/product/' . $row->product->id) }}">
                                    <p class="text-gray-2 weight-600" style="text-align:left; vertical-align: middle">{{ $row->product->name }}</p>
                                </a>
                            </div>
                        </div>
                        <hr style="border-color:F2F2F2">
                        <div class="row ml-3 mb-1">
                            <h6 class="float-left">
                                @for($i = 0; $i < 5; $i++) 
                                @if ($i < $row->rate)
                                    <span class="fa fa-star checked d-inline-flex align-self-end"></span>
                                    @else
                                    <span class="fa fa-star"></span>
                                @endif
                                @endfor
                            </h6>
                        </div>
                        <p class="text-gray-2 ml-3 mr-3" style="text-align:left">{{ $row->customer->name }}</p>
                        <p class="text-gray-2 ml-3 mr-3" style="text-align:left">{{ $row->text }}</p>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>

</script>
@endsection