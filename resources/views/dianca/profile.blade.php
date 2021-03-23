@extends('layouts.store')

@section('title')
<title>Profil</title>
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container-fluid text-gray-2">
            <div class="row my-2">
                <div class="col-lg-12">
                    <div class="main_title">
                        <div class="row">
                            <div class="col-lg-1 md-1 sm-1">
                                <img id="image" class="" src="{{ asset('img/boy.png') }}" alt="profil">
                            </div>
                            <div class="col-lg-3 md-3 sm-3">
                                <h5 class="">{{ Auth::guard('customer')->user()->name }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-12">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <div class="row text-center" style="color: #4F4F4F">
                                <div class="col-lg-4 md-4 sm-4">
                                    <a href="{{ route('profile') }}" style="color: #F37020">Biodata Diri</a>
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
                                
                                    <div class="col-lg-4 md-4 sm-4 text-center mt-3">
                                        <div class="container" style="background: #727272; height:20rem; width:18rem">
                                            <div class="form-group">
                                                <!-- <input type="file" id="image" name="image" class="form-control" value="{{ $customer->image }}" style="5rem" required> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 md-8 sm-8">
                                        <form action="{{ route('edit.profile') }}" method="post" id="profile-form">
                                            @csrf
                                            <div class="row">
                                                <h5 class="mt-3 ml-2" style="color: #4F4F4F"><strong>Ubah Biodata Diri</strong></h5>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nama</label>
                                                <div class="col-lg-6 md-6 sm-6">
                                                    <input type="text" class="form-control border" id="name" name="name" value="{{ $customer->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                <div class="col-lg-6 md-6 sm-6">
                                                    <input type="text" class="form-control border" id="birthday" name="birthday" value="{{ $customer->birthday }}" placeholder="MM / DD / YYYY">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                                <div class="col-lg-6 md-6 sm-6">
                                                    <select id="gender" name="gender" class="form-control border">
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="Laki-laki">Laki-laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                        <option value="{{ $customer->gender }}" {{ $customer->gender == $customer->gender ? 'selected':'' }}>{{ $customer->gender }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h5 class="mt-3 ml-2" style="color: #4F4F4F"><strong>Ubah Kontak</strong></h5>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-lg-6 md-6 sm-6">
                                                    <input type="text" class="form-control border" id="email" name="email" value="{{ $customer->email }}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nomor HP</label>
                                                <div class="col-lg-6 md-6 sm-6">
                                                    <input type="text" class="form-control border" id="phone_number" name="phone_number" value="{{ $customer->phone_number }}" placeholder="Tambah Nomor Ponsel">
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-lg-3 md-3 sm-3"></div>
                                            <div class="col-lg-8 md-8 sm-8">
                                                <button class="btn btn-outline-orange bg-orange mt-3" style="color: white;" aria-disabled="true"><h6>Jaga akun anda agar tetap aman dengan <strong>Verifikasi nomor ponsel</strong></h6></button>
                                                <h6 class="mt-3" style="color: #828282">Untuk kelancaran transaksi anda, silahkan tambahkan nomor yang dapat kami hubungi.</h6>
                                                <button class="btn btn-orange float-right" id="profile">Simpan</button>
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
<script>
    $('#profile').click(function (e) {
        e.preventDefault();
        $('#profile-form').submit();
    });
</script>
@endsection