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
                                @foreach($address as $var)
                                <div class="row pl-4 ml-4 mt-2" style="color: #828282">
                                    <div class="col-lg-3 md-3 sm-3">
                                        <h5>{{ $var->receiver_name }}</h5>
                                        <h5>{{ $var->receiver_phone }}</h5>
                                    </div>
                                    <div class="col-lg-5 md-5 sm-5">
                                        <h5>{{ $var->address_type }}</h5>
                                        <h5>{{ $var->address }}</h5>
                                    </div>
                                    <div class="col-lg-4 md-4 sm-4">
                                        <h5>{{ $var->city ,  $var->postal_code}}</h5>
                                        <h5>Indonesia</h5>
                                        <button class="btn btn-outline-orange ml-4 mt-4" data-toggle="modal" data-target="#editAddress" onclick="editAddress({{ $var->id }})">Ubah</button>
                                        <button class="btn btn-outline-orange ml-4 mt-4">Hapus</button>
                                    </div>
                                    <!-- <div class="row">
                                        <button class="btn btn-outline-orange mr-2 mt-4 float-right" data-toggle="modal" data-target="#editAddress">Ubah</button>
                                        <button class="btn btn-outline-orange mt-4">Hapus</button>
                                    </div> -->
                                </div>
                                @endforeach
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
                            <form action="{{ route('profile-address.add') }}" method="post" id="addAddress-form">
                                @csrf
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-10">
                                        <label>Jenis Alamat</label><br>
                                        <input type="text" name="address_type" id="address_type" class="form-control"
                                            style="background: #F6F6F6" required>
                                        <p class="text ml-1" style="color: #828282">Contoh : Alamat Kantor, Alamat Rumah,
                                            Apartemen</p>
                                        <input type="hidden" value="{{ auth()->guard('customer')->user()->id }}" id="customer_id" name="customer_id">
                                    </div>
                                    <div class="col-md-2 form-check">
                                        <label class="form-check-label" for="is_main">
                                            Alamat utama?
                                        </label>
                                        <input class="form-check-input" type="checkbox" value="" id="is_main" name="is_main">
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label>Nama Penerima</label>
                                        <input type="text" class="form-control" id="receiver_name" name="receiver_name"
                                            style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nomor Telepon</label>
                                        <input type="text" class="form-control" id="receiver_phone" name="receiver_phone"
                                            style="background: #F6F6F6" required>
                                        <p class="text ml-1" style="color: #828282">Contoh : 081234567890</p>
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label>Provinsi</label>
                                        <select id="province_id" name="province_id" class="form-control bg-light-2">
                                            <option value="" selected>Pilih</option>
                                            @foreach($provinces as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Kota/Kabupaten</label>
                                        <select id="city_id" name="city_id" class="form-control bg-light-2">
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-8">
                                        <label>Kecamatan</label>
                                        <select id="district_id" name="district_id" class="form-control bg-light-2">
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code"
                                            style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label>Alamat</label><br>
                                    <textarea name="address" id="address" cols="60" rows="4" class="form-control"
                                        style="background: #F6F6F6; border: none" required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <div class="cart-inner">
                                    <div class="out_button_area">
                                        <div class="checkout_btn_inner">
                                            <a id="close-add-address" class="btn btn-outline-gray" data-dismiss="modal">Batal</a>
                                            <a type="submit" class="btn btn-orange weight-600" id="add-address">Tambah</a>
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
                            <form action="{{ route('profile-address.edit', $var->id) }}" method="post" id="editAddress-form">
                                @csrf
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-10">
                                        <label>Jenis Alamat</label><br>
                                        <input type="text" name="address_type" id="address_type" class="form-control" value="{{ $address->address_type ?? '' }}"
                                            style="background: #F6F6F6" required>
                                        <p class="text ml-1" style="color: #828282">Contoh : Alamat Kantor, Alamat Rumah,
                                            Apartemen</p>
                                        <input type="hidden" value="{{ auth()->guard('customer')->user()->id }}" id="customer_id" name="customer_id">
                                        <input type="hidden" value="{{ $address->id }}" id="address_id" name="address_id">
                                    </div>
                                    <div class="col-md-2 form-check">
                                        <label class="form-check-label" for="is_main">
                                            Alamat utama?
                                        </label>
                                        <input class="form-check-input" type="checkbox" id="is_main" name="is_main">
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label>Nama Penerima</label>
                                        <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="{{ $address->receiver_name ?? '' }}"
                                            style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nomor Telepon</label>
                                        <input type="text" class="form-control" id="receiver_phone" name="receiver_phone"
                                            style="background: #F6F6F6" value="{{ $address->receiver_phone ?? '' }}" required>
                                        <p class="text ml-1" style="color: #828282">Contoh : 081234567890</p>
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label>Provinsi</label>
                                        <select id="province_id" name="province_id" class="form-control bg-light-2">
                                            <option value="" selected>Pilih</option>
                                            @foreach($provinces as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Kota/Kabupaten</label>
                                        <select id="city_id" name="city_id" class="form-control bg-light-2">
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-8">
                                        <label>Kecamatan</label>
                                        <select id="district_id" name="district_id" class="form-control bg-light-2">
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $address->postal_code ?? '' }}"
                                            style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label>Alamat</label><br>
                                    <textarea name="address" id="address" cols="60" rows="4" class="form-control"
                                        style="background: #F6F6F6; border: none" required>{{ $address->address ?? '' }}</textarea>
                                </div>
                            </form>
                        </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <div class="cart-inner">
                                    <div class="out_button_area">
                                        <div class="checkout_btn_inner">
                                            <a id="close-add-address" class="btn btn-outline-gray" data-dismiss="modal">Batal</a>
                                            <a type="submit" class="btn btn-orange weight-600" id="edit-address">Tambah</a>
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
    <script>
        // $('editAddress').click(function (e) {
        //     e.preventDefault();
        //     $('#editAddress-form').submit();
        // });
        $("#province_id").on('change', function() {
            $.ajax({
                url: "{{ route('cities') }}",
                type: 'GET',
                data: {
                    province_id: $(this).val()
                },
                dataType: "JSON",
                success: function(res) {
                    $("#city_id").empty();
                    $.each(res, function(key, item) {
                        $("#city_id").append('<option value="' + item.id + '">' + item
                            .type + " " + item.name + '</option>');
                    });
                    @if(auth()->guard('customer')->user()->address != 0)
                        $('#city_id').val({{ $address->district->city->id }}).change();
                    @endif
                },
            });
        });

        $("#city_id").on('change', function() {
            $.ajax({
                url: "{{ route('districts') }}",
                type: 'GET',
                data: {
                    city_id: $(this).val()
                },
                dataType: "JSON",
                success: function(res) {
                    $("#district_id").empty();
                    $.each(res, function(key, item) {
                        $("#district_id").append('<option value="' + item.id + '">' +
                            item.name + '</option>');
                    });
                    @if(auth()->guard('customer')->user()->address != 0)
                        $('#district_id').val({{ $address->district->id }}).change();
                    @endif
                },
            });
        });

        $('#add-address').click(function (e) {
            e.preventDefault();
            $('#addAddress-form').submit();
        });
        $('#edit-address').click(function (e) {
            e.preventDefault();
            $('#editAddress-form').submit();
        });
    </script>
@endsection