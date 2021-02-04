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
                                <div class="col-lg-4 md-4 sm-4">
                                    <h6>Biodata Diri</h6>
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <a href="{{ route('profile-address') }}" style="color: #4F4F4F">Daftar Alamat</a>
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <a href="{{ route('profile-rekening') }}" style="color: #4F4F4F">Rekening Bank</a>
                                </div>
                            </div>
                            <div class="container">
                                <hr class="pb-2" style="border-color:F2F2F2">
                            </div>
                            <div class="row">
                                <div class="col-lg-4 md-4 sm-4 text-center">
                                    <div class="container" style="background: #727272; height:20rem; width:18rem">.</div>
                                </div>
                                <div class="col-lg-8 md-8 sm-8">
                                    <div class="row">
                                        <div class="col-lg-3 md-3 sm-3">
                                            <h5 class="mt-3" style="color: #4F4F4F"><strong>Ubah Biodata Diri</strong></h5>
                                            <h6 class="mt-4" style="color: #828282">Nama</h6>
                                            <h6 class="mt-4" style="color: #828282">Tanggal Lahir</h6>
                                            <h6 class="mt-4" style="color: #828282">Jenis Kelamin</h6>
                                            <h5 class="mt-4" style="color: #4F4F4F"><strong>Ubah Biodata Diri</strong></h5>
                                            <h6 class="mt-4" style="color: #828282">Email</h6>
                                            <h6 class="mt-4" style="color: #828282">Nomor HP</h6>
                                        </div>
                                        <div class="col-lg-7 md-7 sm-7">
                                            <h5 class="mt-3" style="color: white"><strong>.</strong></h5>
                                            <h6 class="mt-4" style="color: #828282">Naim</h6>
                                            <h6 class="mt-4" style="color: #828282">Tambah Tanggal Lahir</h6>
                                            <h6 class="mt-4" style="color: #828282">Tambah Jenis Kelamin</h6>
                                            <h5 class="mt-4" style="color: white"><strong>.</strong></h5>
                                            <h6 class="mt-4" style="color: #828282">ranawidjannaim@gmail.com</h6>
                                            <h6 class="mt-4" style="color: #828282">Tambah Nomor Ponsel</h6>
                                            <button class="btn btn-outline-orange bg-orange mt-3" style="color: white; width:30rem; height:2rem" aria-disabled="true"><h6>Jaga akun anda agar tetap aman dengan <strong>Verifikasi nomor ponsel</strong></h6></button>
                                            <h6 class="mt-3" style="color: #828282">Untuk kelancaran transaksi anda, silahkan tambahkan nomor yang dapat kami hubungi.</h6>
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
@endsection

@section('js')
@endsection