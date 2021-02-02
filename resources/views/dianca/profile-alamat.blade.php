@extends('layouts.store')

@section('title')
<title>Profil</title>
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            <div class="row my-2">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h5 class="pl-3">Nama Klien</h5>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-12">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <div class="row text-center" style="color: #4F4F4F">
                                <!-- <h4>Biodata Diri</h4> -->
                                <div class="col-lg-4 md-4 sm-4">
                                    <a href="{{ route('profile') }}" style="color: #4F4F4F">Biodata Diri</a>
                                    <!-- <h5>Biodata Diri</h5> -->
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <h6>Daftar Alamat</h6>
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <a href="{{ route('profile-rekening') }}" style="color: #4F4F4F">Rekening Bank</a>
                                    <!-- <h5>Rekening Bank</h5> -->
                                </div>
                            </div>
                            <div class="container">
                                <hr class="pb-2" style="border-color:F2F2F2">
                            </div>
                            <div>
                                <button class="btn btn-outline-orange bg-orange ml-5 mb-5" style="color: white" aria-disabled="true">+ Tambah Alamat Baru</button>
                                <div class="row pl-4 ml-4 mt-3" style="color: #4F4F4F">
                                    <div class="col-lg-3 md-3 sm-3">
                                        <h5>Nama Penerima</h5>
                                    </div>
                                    <div class="col-lg-5 md-5 sm-5">
                                        <h5>Alamat Pengiriman</h5>
                                    </div>
                                    <div class="col-lg-4 md-4 sm-4">
                                        <h5>Daerah Pengiriman</h5>
                                    </div>
                                </div>
                                <div class="container">
                                    <hr class="pb-2" style="border-color:F2F2F2">
                                </div>
                                <div class="row pl-4 ml-4 mt-2" style="color: #828282">
                                    <div class="col-lg-3 md-3 sm-3">
                                        <h5>Rana Widjan Naim 081234567890</h5>
                                    </div>
                                    <div class="col-lg-5 md-5 sm-5">
                                        <h5>Rumah Jl. Remaja, RT01 RW01, Ds. Patianrowo</h5>
                                    </div>
                                    <div class="col-lg-4 md-4 sm-4">
                                        <h5>Patianrowo, Kab. Nganjuk, 64191, Indonesia</h5>
                                    </div>
                                    <div class="row">
                                        <button class="btn btn-outline-orange mr-2 mt-4 float-right">Ubah</button>
                                        <button class="btn btn-outline-orange mt-4">Hapus</button>
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
@endsection

@section('js')
@endsection