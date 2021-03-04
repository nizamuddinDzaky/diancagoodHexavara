@extends('layouts.store')

@section('title')
    <title>Registrasi</title>
@endsection

@section('content')
    <div class="align-items-center d-flex min-vh-100 section_gap">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-1 md-1 sm-1"></div>
                <div class="col-lg-5 md-5 sm-5 pt-5">
                    <div class="container my-auto">
                        <div>
                            <img class="responsive" src="{{ asset('img/register.png') }}">
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-1"></div> -->
                <div class="col-lg-5 md-5 sm-5 pt-5 pl-5 ml-4">
                    <div class="card shadow-1 my-auto pt-2" style="width: 85%">
                        <div class="card-body">
                            <h3 class="card-title text-center pb-1"><strong>Daftar akun baru</strong></h3>
                            <h6 class="card-subtitle mb-2 text-muted text-center">Lorem ipsum is simply dummy text</h6>
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <form action="{{ route('customer.post_register') }}" class="form pl-3 pr-3 pt-4" id="register-form" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama</label><br>
                                    <input type="text" name="name" id="name" class="form-control bg-light @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label><br>
                                    <input type="text" name="email" id="email" class="form-control bg-light @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phone">Nomor Telepon</label><br>
                                    <input type="phone" name="phone" id="phone" class="form-control bg-light @error('phone') is-invalid @enderror" required autocomplete="new-phone">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label><br>
                                    <input type="password" name="password" id="password" class="form-control bg-light @error('password') is-invalid @enderror" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label><br>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control bg-light" required autocomplete="new-password">
                                </div>
                                <div class="form-group pt-4 text-center">
                                    <input type="submit" value="Daftar Sekarang" name="register_submit"
                                        id="register_submit" class="form-control form-control-lg bg-orange"
                                        style="color: white">
                                    <label class="text-muted text-center pt-2">Sudah punya akun? <a href="{{ route('customer.login') }}"
                                            style="color:orange;font-weight:bold">Masuk Sekarang</a></label><br>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection