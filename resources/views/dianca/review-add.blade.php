@extends('layouts.store')

@section('title')
<title>Perlu Diulas</title>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            <div class="row my-2">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2 class="pl-3">Perlu Diulas</h2>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-12">
                    <ul class="filter-buttons">
                        <li>
                            <a href="{{ route('reviews.list', 0) }}" type="button" class="btn btn-filter"
                                id="unreviewed">Perlu Diulas</a>
                        </li>
                        <li>
                            <a href="{{ route('reviews.list', 1) }}" type="button" class="btn btn-filter"
                                id="reviewed">Ulasan Saya</a>
                        </li>
                    </ul>
                </div>
            </div>
            @forelse($orders as $row)
            <div class="row my-4">
                <div class="col-lg-12">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <div class="row d-flex mb-2 justify-content-between">
                                <div class="col-lg-3 col-sm-12">
                                    <h6>Nomor Pemesanan</h6>
                                    <h5 class="weight-600">{{ $row->invoice }}</h5>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <h6>Tanggal Pemesanan</h6>
                                    <h5 class="weight-600">{{ $row->created_at }}</h5>
                                </div>
                            </div>
                            @foreach($row->details as $od)
                            @if($od->review->status == 0)
                            <form action="{{ route('reviews.add') }}" method="POST">
                                @csrf
                                <div class="row d-flex justify-content-between mt-2">
                                    <div class="col-lg-12">
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="{{ asset('storage/products/' . $od->variant->product->images->first()->filename) }}"
                                                    width="100px" height="100px">
                                            </div>
                                            <div class="media-body">
                                                <h4 class="weight-600"><a class="text-orange"
                                                        href="{{ url('/product/' . $od->variant->product->id) }}">{{ $od->variant->product->name }}</a>
                                                </h4>
                                                <p><small>Varian {{ $od->variant->name }} <span
                                                            class="ml-2">{{ $od->weight }} gr</span></small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex mt-2 pl-3 justify-content-between review">
                                        <div class="col-sm-12">
                                            <p class="mt-4 mb-2">Bagaimana kualitas barang ini?</p>
                                            <input class="form-control border-3 w-25" type="text" name="rate">
                                            <p class="mt-4 mb-2">Berikan ulasan barang ini...</p>
                                            <textarea class="form-control review-text w-100" rows="5" placeholder="Ulasan" name="text" required></textarea>
                                            <input type="hidden" name="order_detail_id" value="{{ $od->id }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-right">
                                        <button type="button" class="btn btn-outline-gray-3 font-16 px-5 py-2 m-2"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" id="submit-review"
                                            class="btn btn-orange font-16 px-5 py-2 m-2">Kirim</button>
                                    </div>
                                </div>
                            </form>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="row my-4">
                <div class="col-lg-12">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h4>Belum ada ulasan.</h4>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
$(document).ready(function() {
    if (window.location.href.indexOf("/0") > -1) {
        $("#unreviewed").addClass('filter-active');
    } else if (window.location.href.indexOf("/1") > -1) {
        $("#reviewed").addClass('filter-active');
    }
});
</script>
@endsection