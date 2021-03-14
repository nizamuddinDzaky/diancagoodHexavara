@extends('layouts.store')

@section('title')
<title>Perlu Diulas</title>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            <div class="row my-2">
                <div class="col-lg-6 md-6 sm-6 mb-3">
                    <ul class="filter-buttons">
                        <li>
                            <a href="{{ route('reviews.list') }}" type="button" class="btn btn-filter"
                                id="unreviewed">Perlu Diulas</a>
                        </li>
                        <li>
                            <a href="{{ route('reviews.done') }}" type="button" class="btn btn-filter"
                                id="reviewed">Ulasan Saya</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 md-6 sm-6">
                    <div class="btn-toolbar mb-1" role="toolbar">
                        <form action="{{ route('reviews.list') }}" method="get">
                            <div class="input-group mb-3 float-left">
                                <div class="col-lg-5 md-5 sm-5 mb-3">
                                    <input type="date" name="from_date" id="from_date" class="form-control border" placeholder="From Date">
                                </div>
                                <div class="col-lg-5 md-5 sm-5 mb-3">
                                    <input type="date" name="to_date" id="to_date" class="form-control border" placeholder="To Date">
                                </div>
                                <div class="col-lg-2 md-2 sm-2">
                                    <button class="btn btn-orange" type="submit" id="filter">Filter</button>
                                </div>
                                <!-- <input type="text" id="created_at" name="date" class="form-control"> -->
                                <!-- <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">Filter</button>
                                </div> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @forelse($orders as $row)
            @if($jumlah != 0)
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
                            @if($od->review_status == 0)
                            <form action="{{ route('reviews.add') }}" method="POST" id="#review-form">
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
                                            <div class="stars">
                                                <input class="star star-5" id="star-5" type="radio" name="rate" value="5"/>
                                                <label class="star star-5" for="star-5"></label>
                                                <input class="star star-4" id="star-4" type="radio" name="rate" value="4"/>
                                                <label class="star star-4" for="star-4"></label>
                                                <input class="star star-3" id="star-3" type="radio" name="rate" value="3"/>
                                                <label class="star star-3" for="star-3"></label>
                                                <input class="star star-2" id="star-2" type="radio" name="rate" value="2"/>
                                                <label class="star star-2" for="star-2"></label>
                                                <input class="star star-1" id="star-1" type="radio" name="rate" value="1"/>
                                                <label class="star star-1" for="star-1"></label>
                                            </div>
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
            @endif
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
    if (window.location.href.indexOf("/") > -1) {
        $("#unreviewed").addClass('filter-active');
    } else if (window.location.href.indexOf("/done") > -1) {
        $("#reviewed").addClass('filter-active');
    }
});
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $('#filter').click(function() {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' && to_date != '') {
            fetch_data(from_date, to_date);
        }
        else {
            alert('Both Date is required');
        }
    });
</script>
@endsection