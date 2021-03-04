@extends('layouts.store')

@section('title')
<title>DiancaGoods</title>
@endsection

@section('content')
<section class="cat_product_area section_gap mt-4">
    <div class="container-fluid">
        <div class="row flex-row-reverse py-4">
            <div class="col-lg-9">
                <div class="latest_product_inner row">
                    @forelse ($products as $row)
                    <div class="col">
                        <div class="f_p_item curved-border plain-border">
                            <div class="f_p_img">
                                <a href="{{ url('/product/' . $row->id) }}">
                                    <img class="product-center-cropped curved-border-3"
                                        src="{{ asset('storage/products/' . $row->images->first()->filename) }}"
                                        alt="{{ $row->name }}">
                                </a>
                            </div>
                            <div class="px-2">
                                <a href="{{ url('/product/' . $row->id) }}">
                                    <h4 class="text-gray-2 font-18">{{ $row->name }}</h4>
                                </a>
                                @if( number_format($row->variant->first()->price) !=
                                number_format($row->variant->last()->price) )
                                <h5>Rp {{ number_format($row->variant->first()->price) }} - Rp
                                    {{ number_format($row->variant->last()->price) }}</h5>
                                @else
                                <h5>Rp {{ number_format($row->variant->first()->price) }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <h3 class="text-center">Tidak ada produk</h3>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-3">
                <div class="left_sidebar_area">
                    <div class="card shadow-1 px-2">
                        <div class="card-body">
                            <h4 class="weight-600">Kategori Barang</h4>
                            <div class="pl-4 py-2">
                                @foreach($categories as $c)
                                <h5><a class="text-gray-3" href="{{ url('/category/' . $c->id) }}">{{ $c->name }}</a>
                                </h5>
                                @endforeach
                            </div>
                            <hr>
                            <h4 class="weight-600">Brand</h4>
                            <div class="pl-4 py-2">
                                @foreach($brands as $b)
                                <h5><a class="text-gray-3" href="{{ url('/brand/' . $b->id) }}">{{ $b->name }}</a>
                                </h5>
                                @endforeach
                            </div>
                            <hr>
                            <h4 class="weight-600">Harga</h4>
                            <div class="py-2">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <div class="input-group-text bg-3 border-3">Rp</div>
                                    </div>
                                    <input type="text" name="min" class="form-control bg-white border-3"
                                        placeholder="Minimum">
                                </div>
                            </div>
                            <div class="py-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-3 border-3">Rp</div>
                                    </div>
                                    <input type="text" name="max" class="form-control bg-white border-3"
                                        placeholder="Maksimum">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
@endsection