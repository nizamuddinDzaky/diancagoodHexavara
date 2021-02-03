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
                                    <a href="{{ route('profile') }}" style="color: #4F4F4F">Biodata Diri</a>
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <h6>Daftar Alamat</h6>
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <a href="{{ route('profile-rekening') }}" style="color: #4F4F4F">Rekening Bank</a>
                                </div>
                            </div>
                            <div class="container">
                                <hr class="pb-2" style="border-color:F2F2F2">
                            </div>
                            <div>
                                <button class="btn btn-outline-orange bg-orange ml-5 mb-5" style="color: white" aria-disabled="true" data-toggle="modal" data-target="#addAddress">+ Tambah Alamat Baru</button>
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
                                        <h5>Rana Widjan Naim</h5>
                                        <h5>081234567890</h5>
                                    </div>
                                    <div class="col-lg-5 md-5 sm-5">
                                        <h5>Rumah</h5>
                                        <h5>Jl. Remaja, RT01 RW01, Ds. Patianrowo</h5>
                                    </div>
                                    <div class="col-lg-4 md-4 sm-4">
                                        <h5>Patianrowo, Kab. Nganjuk, 64191,</h5>
                                        <h5>Indonesia</h5>
                                        <button class="btn btn-outline-orange ml-4 mt-4" data-toggle="modal" data-target="#editAddress">Ubah</button>
                                        <button class="btn btn-outline-orange ml-4 mt-4">Hapus</button>
                                    </div>
                                    <!-- <div class="row">
                                        <button class="btn btn-outline-orange mr-2 mt-4 float-right" data-toggle="modal" data-target="#editAddress">Ubah</button>
                                        <button class="btn btn-outline-orange mt-4">Hapus</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade w-100" id="addAddress" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute" style="color: #333333">Buat Alamat Baru</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="cart_inner">
                            <form action="" method="post" id="addAddress-form">
                                @csrf
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label style="color: black">Jenis Alamat</label><br>
                                    <input type="text" name="alamat" id="jenisalamat" class="form-control" style="background: #F6F6F6" required>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label style="color: black">Nama Penerima</label>
                                        <input type="text" class="form-control" id="receiver" style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label style="color: black">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="phone" style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-8">
                                        <label style="color: black">Kota atau Kecamatan</label>
                                        <input type="text" class="form-control" id="kota" placeholder="Patienworo, Kab. Nganjuk" style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label style="color: black">Kode Pos</label>
                                        <input type="text" class="form-control" id="kodepos" style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label style="color: black">Alamat</label><br>
                                    <textarea name="alamat" id="alamat" cols="60" rows="4" class="form-control" style="background: #F6F6F6; border: none" required></textarea>
                                    <!-- <input type="text" name="alamat" id="alamat" class="form-control" style="background: #F6F6F6" required> -->
                                </div>
                            </form>
                        </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <div class="cart-inner">
                                    <div class="out_button_area">
                                        <div class="checkout_btn_inner">
                                            <a class="btn btn-outline-secondary" style="width: 7rem; height:40px" href="#">Batal</a>
                                            <a class="btn btn-outline-orange bg-orange" style="color: white" href="#" id="checkout-go">Tambah</a>
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
    <div class="modal fade w-100" id="editAddress" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute" style="color: #333333">Ubah Alamat</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="cart_inner">
                            <form action="" method="post" id="addAddress-form">
                                @csrf
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label style="color: black">Jenis Alamat</label><br>
                                    <input type="text" name="alamat" id="jenisalamat" class="form-control" style="background: #F6F6F6" required>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label style="color: black">Nama Penerima</label>
                                        <input type="text" class="form-control" id="receiver" style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label style="color: black">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="phone" style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-8">
                                        <label style="color: black">Kota atau Kecamatan</label>
                                        <input type="text" class="form-control" id="kota" placeholder="Patienworo, Kab. Nganjuk" style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label style="color: black">Kode Pos</label>
                                        <input type="text" class="form-control" id="kodepos" style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label style="color: black">Alamat</label><br>
                                    <textarea name="alamat" id="alamat" cols="60" rows="4" class="form-control" style="background: #F6F6F6; border: none" required></textarea>
                                    <!-- <input type="text" name="alamat" id="alamat" class="form-control" style="background: #F6F6F6" required> -->
                                </div>
                            </form>
                        </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <div class="cart-inner">
                                    <div class="out_button_area">
                                        <div class="checkout_btn_inner">
                                            <a class="btn btn-outline-secondary" style="width: 7rem; height:40px" href="#">Batal</a>
                                            <a class="btn btn-outline-orange bg-orange" style="color: white" href="#" id="checkout-go">Simpan</a>
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
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection