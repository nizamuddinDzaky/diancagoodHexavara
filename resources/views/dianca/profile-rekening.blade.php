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
                                    <a href="{{ route('profile-address') }}" style="color: #4F4F4F">Daftar Alamat</a>
                                    <!-- <h5>Daftar Alamat</h5> -->
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <h6>Rekening Bank</h6>
                                </div>
                            </div>
                            <div class="container">
                                <hr class="pb-2" style="border-color:F2F2F2">
                            </div>
                            <div class="row ml-4 pl-3">
                                <div class="col-lg-5 md-5 sm-5">
                                    <h5 style="color: #4F4F4F">Daftar Rekening Bank</h5>
                                    <h6 style="color: #828282">Rekening Bank yang aktif maksimal berjumlah tiga akun</h6>
                                </div>
                                <div class="col-lg-3 md-3 sm-3"></div>
                                <div class="col-lg-3 md-3 sm-3 ml-5">
                                    <button class="btn btn-outline-orange bg-orange ml-5 mb-5" style="color: white" aria-disabled="true">+ Tambah Rekening</button>
                                </div>
                            </div>
                            <div class="row ml-4 mt-4">
                                <div class="col-lg-2 md-2 sm-2">Logo Bank</div>
                                <div class="col-lg-8 md-8 sm-8">
                                    <h6 style="color: #828282">PT. BANK NEGARA INDONESIA (BNI) (PERSERO)</h6>
                                    <h6 style="color: #4F4F4F">800 152 6846</h6>
                                    <h6 style="color: #828282">a.n <h6 style="color: #4F4F4F">Sdr RANA WIJDAN NAIM</h6></h6>
                                </div>
                                <div class="col-lg-2 md-2 sm-2">
                                    <button class="btn btn-outline-orange mt-4">Hapus</button>
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