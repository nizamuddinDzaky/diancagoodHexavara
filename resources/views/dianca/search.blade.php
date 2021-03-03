@extends('layouts.store')

@section('title')
<title>DiancaGoods</title>
@endsection

@section('content')
<section class="">
    <div class="">
        <div class="container">
            <div class="row my-2 pb-4 pt-4 pl-2">
                <div class="main_title">
                    <h2 style="color: white">SEARCH</h2>
                </div>
            </div>
            <div class="row my-2 pb-2 pt-2 pl-2">
                <div class="col-lg-5 md-5 sm-5"><h5>Menampilkan hasil pencarian produk untuk “skincare”</h5></div>
                <div class="col-lg-5 md-5 sm-5"></div>
                <div class="col-lg-2 md-2 sm-2 float-right">
                    <button class="btn dropdown-toggle border" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Urutkan: Paling Sesuai
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Paling Banyak Dibeli</a>
                        <a class="dropdown-item" href="#">Termurah</a>
                        <a class="dropdown-item" href="#">Termahal</a>
                    </div>
                </div>
            </div>
            <div class="row my-2 pb-2 pt-3">
                <div class="col-lg-3 pb-3">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <div class="option">
                                <h4 class="py-0 weight-600">Kategori Barang</h4>
                                <i class="material-icons md-18 float-right">keyboard_arrow_up</i>
                            </div>
                            <ul class="option-text text-gray-3 font-14" style="list-style-type:none;">
                            @foreach ($category as $v)
                                <li class="border-0 {{ request()->segment(2) == $v->slug ? 'active' : '' }} pb-2 pt-2">
                                    <a href="{{ url('/category/' . $v->slug) }}" class="option-text text-gray-3 font-14"><h5>{{ $v->name }}</h5></a>
                                </li>
                            @endforeach
                            </ul>
                            <hr>
                            <div class="option">
                            <h4 class="py-0 weight-600">Brand</h4>
                                <i class="material-icons md-18 float-right">keyboard_arrow_up</i>
                            </div>
                            <ul class="option-text text-gray-3 font-14" style="list-style-type:none;">
                            @foreach ($brand as $val)
                                <li class="border-0 {{ request()->segment(2) == $val->slug ? 'active' : '' }} pb-2 pt-2">
                                    <a href="{{ url('/brand/' . $val->slug) }}" class="option-text text-gray-3 font-14 hover"><h5>{{ $val->name }}</h5></a>
                                </li>
                            @endforeach
                            </ul>
                            <hr>
                            <div class="option">
                            <h5 class="py-0 weight-600">Harga</h5>
                                <i class="material-icons md-18 float-right">keyboard_arrow_up</i>
                            </div>
                            <form action="">
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="background:#F2F2F2">Rp</div>
                                        </div>
                                        <input type="text" class="form-control" id="" placeholder="Minimum">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="background:#F2F2F2">Rp</div>
                                        </div>
                                        <input type="text" class="form-control" id="" placeholder="Maksimum">
                                    </div>
                                </div>
                                <button class="btn btn-orange ml-3 mt-2 text-center" style="width: 12rem">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row my-2 ml-3">
                        @forelse($product as $row)
                        <div class="col ml-2">
                            <div class="page-wrapper">
                                <div class="f_p_item">
                                    <div class="f_p_img">
                                        <a href="{{ url('/product/' . $row->id) }}">
                                            <img id="pic{{ $row }}" class="home-product-center-cropped" src="{{ asset('storage/products/' . $row->images->first()->filename) }}" alt="{{ $row->name }}">
                                        </a>
                                    </div>
                                    <a href="{{ url('/product/' . $row->id) }}" class="overflow-visible mb-2">
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
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@endsection