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
                        <div class="row">
                            <div class="col-lg-1 md-1 sm-1">
                                <img id="image" class="" src="{{ asset('img/boy.png') }}" alt="profil">
                            </div>
                            <div class="col-lg-4 md-4 sm-4">
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
                                    <a href="{{ route('profile') }}" style="color: #4F4F4F">Biodata Diri</a>
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <a href="{{ route('profile-address') }}" style="color: #4F4F4F">Daftar Alamat</a>
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
                                @if ($sum != 3)
                                <div class="col-lg-3 md-3 sm-3 ml-5">
                                    <button class="btn btn-outline-orange bg-orange ml-5 mb-5" style="color: white" aria-disabled="true" data-toggle="modal" data-target="#addRekening">+ Tambah Rekening</button>
                                </div>
                                @endif
                            </div>
                            @foreach ($account as $v)
                            <div class="row ml-4 mt-4">
                                <div class="col-lg-1 md-1 sm-1">
                                    <img class="" src="{{ asset('storage/banks/' . $v->bank->image) }}" width="70px">
                                </div>
                                <div class="col-lg-9 md-9 sm-9">
                                    <h6 style="color: #828282">{{ $v->bank->name }}</h6>
                                    <h6 style="color: #4F4F4F">{{ $v->account_number }}</h6>
                                    <!-- <h6 style="color: #828282">a.n <h6 style="color: #4F4F4F">Sdr RANA WIJDAN NAIM</h6></h6> -->
                                </div>
                                <div class="col-lg-2 md-2 sm-2">
                                    <form action="{{ route('profile-rekening.delete', $v->id) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-orange mt-2"
                                            onclick="return confirm('Hapus Rekening')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade w-100" id="addRekening" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute" style="color: #333333">Tambah Rekening Bank</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="cart_inner">
                            <form action="{{ route('profile-rekening.add') }}" method="post" id="addAccount-form">
                                @csrf
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label style="color: black">Nama Bank</label><br>
                                    <select name="bank_id" class="form-control" style="background: #F6F6F6" required>
                                        <option value="">Pilih</option>
                                        @foreach ($banks as $row)
                                        <option value="{{ $row->id }}" {{ old('bank_id') == $row->id ? 'selected':'' }}>
                                            {{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label style="color: black">Nomor Rekening</label><br>
                                    <input type="text" name="account_number" id="account_number" class="form-control" style="background: #F6F6F6" required>
                                </div>
                            </form>
                        </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <div class="cart-inner">
                                    <div class="out_button_area">
                                        <div class="checkout_btn_inner">
                                            <a class="btn btn-outline-secondary" style="width: 7rem; height:40px" href="#">Batal</a>
                                            <a class="btn btn-outline-orange bg-orange" style="color: white" id="account-go">Tambah</a>
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
    $('#account-go').click(function (e) {
        e.preventDefault();
        $('#addAccount-form').submit();
    });
</script>
@endsection