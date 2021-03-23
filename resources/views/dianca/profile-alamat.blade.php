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
                                    <a href="{{ route('profile-address') }}" style="color: #F37020">Daftar Alamat</a>
                                </div>
                                <div class="col-lg-4 md-4 sm-4">
                                    <a href="{{ route('profile-rekening') }}" style="color: #4F4F4F">Rekening Bank</a>
                                </div>
                            </div>
                            <div class="container">
                                <hr class="pb-2" style="border-color:F2F2F2">
                            </div>
                            <div>
                                <button class="btn btn-outline-orange bg-orange ml-5 mb-5" style="color: white" id="btn-add-address" data-url-add = "{{ route('profile-address.add') }}">+ Tambah Alamat Baru</button>
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
                                        <button class="btn btn-outline-orange ml-4 mt-4 edit-address" data-toggle="modal" data-target="#editAddress" data-id="{{ $var->id }}" data-url-edit="{{ route('profile-address.edit', $var->id) }}" data-url-detail="{{ route('address.detail') }}">Ubah</button>
                                        @if ($var->is_main != 1)
                                        <a href= "{{ route('profile-address.delete', ['id' => $var->id]) }}" class="btn btn-outline-orange ml-4 mt-4">Hapus</a>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade w-100" id="modal-form-address" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute" style="color: #333333" id="title-modal"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="cart_inner">
                            <form action="" method="post" id="address-form">
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
                                        <input class="form-check-input" type="checkbox" value="1" id="is_main" name="is_main">
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
                                            <a type="submit" class="btn btn-orange weight-600" id="add-address">Simpan</a>
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
        var province_id;
        var city_id;
        var district_id;
        $("#province_id").on('change', function() {
            let isSelected = '';
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
                        isSelected = ''
                        if (item.id == city_id) {
                            isSelected = 'selected';
                        }
                        $("#city_id").append('<option value="' + item.id + '" '+isSelected+'>' + item
                            .type + " " + item.name + '</option>');
                    });
                    if (city_id != '' || city_id != undefined) {
                        $("#city_id").change()
                    }
                },
            });
        });
        $("#city_id").on('change', function() {
            let isSelected = '';
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
                        isSelected = ''
                        if (item.id == city_id) {
                            isSelected = 'selected';
                        }
                        $("#district_id").append('<option value="' + item.id + '">' +
                            item.name + '</option>');
                    });
                },
            });
        });
        $('#add-address').click(function (e) {
            e.preventDefault();
            $('#address-form').submit();
        });
        $('.edit-address').click(function () {
            reset_form();
            get_detail_address($(this).data("url-detail"), $(this).data("id"), $(this).data('url-edit'));
        })

        

        async function get_detail_address(url, id, url_form) {
            await $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(res) {
                    if (res.status) {
                        province_id = res.data.province_id;
                        city_id = res.data.city_id;
                        district_id = res.data.district_id;

                        if (res.data.is_main == 1) {
                           $('#is_main').prop( "checked", true ); 
                        }else{
                            $('#is_main').prop( "checked", false ); 
                        }
                        $('#address_type').val(res.data.address_type);
                        // $('#is_main').val(res.data.)
                        $('#receiver_name').val(res.data.receiver_name);
                        $('#receiver_phone').val(res.data.receiver_phone)
                        $('#province_id').val(res.data.province_id).change();
                        $('#address-form').attr('action', url_form);
                        $('#postal_code').val(res.data.postal_code);
                        $('#address').val(res.data.address);
                        $('#title-modal').text('Ubah Alamat');
                        $('#modal-form-address').modal('toggle');
                        $('#modal-form-address').modal('show');
                    }
                },
            });
        }

        $('#btn-add-address').click(function () {
            reset_form();
            $('#address-form').attr('action', $(this).data('url-add'));
            $('#title-modal').text('Buat Alamat Baru');
            $('#modal-form-address').modal('toggle');
            $('#modal-form-address').modal('show');
        });

        function reset_form() {
            province_id = '';
            city_id = '';
            district_id = '';
            document.getElementById("address-form").reset();
            $("#city_id").empty();
            $("#district_id").empty();
            $("#city_id").append('<option value="" >Pilih</option>');
            $("#district_id").append('<option value="" >Pilih</option>');
        }

        
        // $('editAddress').click(function (e) {
        //     e.preventDefault();
        //     $('#editAddress-form').submit();
        // });
        
    </script>
@endsection