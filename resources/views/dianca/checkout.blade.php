@extends('layouts.store')

@section('title')
    <title>Pembelian</title>
@endsection

@section('content')
<form action="{{ route('checkout.payment') }}" method="POST">
@csrf
    <section class="feature_product_area section_gap mt-4" style="height: 240px">
        <div class="main_box pt-4">
            <div class="container">           
                <div class="row my-2">
                    <div class="main_title">
                        <h2 class="pl-3" >Pembayaran</h2>
                        <h5 class="pl-3 pt-2" >1 dari 2 langkah</h5>
                        <!-- <div class="container">
                            <hr class="rounded" style="border-color:F2F2F2">
                        </div> -->
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-4">
                        <hr class="rounded" style="border: 5px solid orange">
                        <h6 style="color: black">1 Checkout</h6>
                    </div>
                    <div class="col-lg-4">
                        <hr class="rounded" style="border: 5px solid gray">
                        <h6 style="color: gray">2 Bayar</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <hr class="pb-2" style="border-color:F2F2F2">
    </div>
    <section class="feature_product_area">
        <div class="main_box">
            <div class="container text-gray-2">
                <div id="#no-address">
                    <div class="row my-2">
                        <div class="main_title text-gray-2">
                            <h3 class="pl-3">Alamat Pengiriman</h3>
                        </div>
                    </div>
                    @if (auth()->guard('customer')->user()->address == 0)
                    <div class="row my-2 pb-3">
                        <div class="col">
                            <a type="button" class="btn btn-outline-orange" href="" aria-disabled="true" data-toggle="modal" data-target="#addressModal">Buat Alamat Baru</a>
                        </div>
                    </div>
                    @endif
                    @if (auth()->guard('customer')->user()->address != 0)
                    <div class="row my-2 pl-3">
                        <h5><strong>{{ $address->receiver_name }}</strong> ({{ $address->address_type }})</h5>
                    </div>
                    <div class="row my-2 pl-3" style="color: #333333">
                        <h5>{{ $address->receiver_phone }}</h5>
                    </div>
                    <div class="row my-2 pb-3 pl-3" style="color: #333333">
                        <h5>{{ $address->address }}</h5>
                        <h5>, {{ $address->city }}</h5>
                        <h5>, {{ $address->postal_code }}</h5>
                    </div>
                    <div class="row my-2 pl-3">
                        <a type="button" class="btn btn-outline-orange" href="" aria-disabled="true" data-toggle="modal" data-target="#editAddress">Edit Alamat</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <hr class="pb-2" style="border-color:F2F2F2">
    </div>
    <section class="feature_product_area">
        <div class="main_box">
            <div class="container">
                <div class="row pt-2 pl-2">
                    <div class="col-lg-8">
                        <div class="row py-2">
                            <div class="col-lg-12 pb-1">
                                @if(auth()->guard('customer')->check())
                                @foreach ($cart_detail as $val)
                                <div class="card shadow-1 mb-3" style="width: 47rem">
                                    <div class="row px-4 py-4">
                                        <div class="col-lg-3">
                                            <a href="#">
                                                <img id="image" class="product-img-sm" src="{{ asset('storage/products/' . $val->variant->product->images->first()->filename) }}" alt="Starterkit">
                                            </a>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row ml-2 pt-3">
                                                <a href="#">
                                                    <h4 class="text-gray-2 weight-600 font-24">{{ $val->variant->product->name }}</h4>
                                                </a>
                                            </div>
                                            <div class="row ml-2 pt-2">
                                                <h5 >{{ $val->qty }} Barang</h5>
                                                <h5>({{ $val->variant->weight }} gr)</h5>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ $val->id }}" name="cd[]">
                                    </div>
                                    <div class="container">
                                        <hr class="" style="border-color:F2F2F2">
                                    </div>
                                    <div class="row px-4 py-2" style="height: 60px">
                                        <div class="col-lg-9">
                                            <h5 class="ml-2" >Sub Total Harga: <strong>Rp {{ number_format($val['price'], 2, ',', '.') }}</strong></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <a type="button" class="btn btn-outline-orange float-right" href="#" aria-disabled="true">Edit</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="container">
                            <hr class="" style="border-color:F2F2F2">
                        </div>
                        <div class="row py-2 ml-2 pb-4">
                                <div class="col-lg-6" style="color: #4F4F4F">
                                    <div class="main_title pb-2">
                                        <h4>Pengiriman</h4>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Jasa Pengiriman</label><br>
                                        <select id="courier" name="courier" class="form-control border border-secondary" style="width:8rem">
                                            <option value="" selected>Pilih</option>
                                            <option value="JNT">JNT</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Durasi</label><br>
                                        <select id="duration" name="duration" class="form-control border border-secondary" style="width:12rem">
                                            <option value="" selected>Pilih</option>
                                            <option value="regular">Regular (4-5 hari)</option>
                                        </select>
                                    </div>
                                </div>
                            
                            <div class="col-lg-6">
                                <div class="main_title pb-2 ml-2">
                                    <h4 style="color: #4F4F4F">Ringkasan Pengiriman</h4>
                                </div>
                                <div class="row px-4 py-2" style="color: #828282">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <h6>Jasa Pengiriman</h6>
                                            </div>
                                            <div class="row pt-1">
                                                <h6>Durasi</h6>
                                            </div>
                                            <div class="row pt-1">
                                                <h6>Estimasi Tiba</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <h6>JNT (Regular)</h6>
                                            </div>
                                            <div class="row pt-1">
                                                <h6>4 - 5 hari</h6>
                                            </div>
                                            <div class="row pt-1">
                                                <h6>24 - 25 Desember 2020</h6>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <div class="card shadow-1">
                            <div class="card-body font-18">
                                <h4 style="color: #828282"><strong>Ringkasan Belanja</strong></h4>
                                <hr>
                                <div class="row py-2">
                                    <div class="col-lg-6" style="color: #828282">
                                        <h5>Total Harga</h5>
                                        <h5>Ongkos Kirim</h5>
                                        <h5>Total Tagihan</h5>
                                    </div>
                                    <div class="col-lg-6 float-right" style="text-align: right">
                                        <h5>Rp {{ number_format($total_cost) }}</h5>
                                        <h5 id="ongkir">Rp 17,000</h5>
                                        <input type="hidden" value="17000" name="shipping_cost">
                                        <input type="hidden" value="{{ $total_cost }}" name="subtotal">
                                            
                                        <h5 id="total"><strong>Rp {{ number_format($total_cost + 17000) }}</strong></h5>
                                    </div>
                                </div>
                                <button class="btn btn-orange weight-600 btn-block font-18 py-2">Pilih Pembayaran</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
    <div class="modal fade w-100" id="addressModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute" >Buat Alamat Baru</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="cart_inner">
                            <form action="{{ route('checkout.address') }}" method="post" id="checkout-form">
                                @csrf
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label >Jenis Alamat</label><br>
                                    <input type="text" name="address_type" id="address_type" class="form-control" style="background: #F6F6F6" required>
                                    <input type="hidden" value="{{ auth()->guard('customer')->user()->id }}" name="customer_id">
                                    <p class="text ml-1" style="color: #828282">Contoh : Alamat Kantor, Alamat Rumah, Apartemen</p>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label >Nama Penerima</label>
                                        <input type="text" class="form-control" id="receiver_name" name="receiver_name" style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label >Nomor Telepon</label>
                                        <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" style="background: #F6F6F6" required>
                                        <p class="text ml-1" style="color: #828282">Contoh : 081234567890</p>
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-8">
                                        <label >Kota atau Kecamatan</label>
                                        <input type="text" class="form-control" id="city" name="city" style="background: #F6F6F6" required>
                                        <p class="text ml-1" style="color: #828282">Contoh : Sukolilo, Surabaya</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label >Kode Pos</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label >Alamat</label><br>
                                    <textarea name="address" id="address" cols="60" rows="4" class="form-control" style="background: #F6F6F6; border: none" required></textarea>
                                    <!-- <input type="text" name="alamat" id="alamat" class="form-control" style="background: #F6F6F6" required> -->
                                </div>
                            </form>
                        </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <div class="cart-inner">
                                    <div class="out_button_area">
                                        <div class="checkout_btn_inner">
                                            <a class="btn btn-outline-secondary" style="width: 7rem; height:40px" href="">Batal</a>
                                            <a class="btn btn-outline-orange bg-orange" style="color: white" href="" id="add-address">Tambah</a>
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
    @if (auth()->guard('customer')->user()->address != 0)
    <div class="modal fade w-100" id="editAddress" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute" >Edit Alamat</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="cart_inner">
                            <form action="" method="post" id="checkout-form">
                                @csrf
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label >Jenis Alamat</label><br>
                                    <input type="text" name="address_type" id="address_type" class="form-control" value="{{ $address->address_type }}" style="background: #F6F6F6" required>
                                    <input type="hidden" value="{{ auth()->guard('customer')->user()->id }}" name="customer_id">
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label >Nama Penerima</label>
                                        <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="{{ $address->receiver_name }}" style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label >Nomor Telepon</label>
                                        <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" value="{{ $address->receiver_phone }}" style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-8">
                                        <label >Kota atau Kecamatan</label>
                                        <input type="text" class="form-control" id="city" name="city" value="{{ $address->city }}" style="background: #F6F6F6" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label >Kode Pos</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $address->postal_code }}" style="background: #F6F6F6" required>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label >Alamat</label><br>
                                    <textarea name="address" id="address" value="" cols="60" rows="4" class="form-control" style="background: #F6F6F6; border: none" required>{{ $address->address }}</textarea>
                                    <!-- <input type="text" name="alamat" id="alamat" class="form-control" style="background: #F6F6F6" required> -->
                                </div>
                            </form>
                        </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <div class="cart-inner">
                                    <div class="out_button_area">
                                        <div class="checkout_btn_inner">
                                            <a class="btn btn-outline-secondary" style="width: 7rem; height:40px" href="">Batal</a>
                                            <a class="btn btn-outline-orange bg-orange" style="color: white" href="" id="add-address">Simpan</a>
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
    @endif
@endsection

@section('js')
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $('#add-address').click(function (e) {
            e.preventDefault();
            $('#checkout-form').submit();
        });
    </script>
    <script>
        $.ajax({
            url: "{{ url('/api/cost') }}",
            type: "POST",
            data: { destination: $(this).val(), weight: $('#weight').val() },
            success: function(html){
                //BERSIHKAN AREA SELECT BOX
                $('#courier').empty()
                $('#courier').append('<option value="">Pilih Kurir</option>')
            
                //LOOPING DATA ONGKOS KIRIM
                $.each(html.data.results, function(key, item) {
                    let courier = item.courier + ' - ' + item.service + ' (Rp '+ item.cost +')'
                    let value = item.courier + '-' + item.service + '-'+ item.cost
                    //DAN MASUKKAN KE DALAM OPTION SELECT BOX
                    $('#courier').append('<option value="'+value+'">' + courier + '</option>')
                })
            }
        });

        $('#courier').on('change', function () {
            let split = $(this).val().split('-');
            $('#ongkir').text('Rp ' + split[2]);

            @if( auth()->guard('customer')->check() )
                var subtotal = "{{ $cart->total_cost }}";
            @else
                var subtotal = "{{ $subtotal }}";
            @endif
            let total = parseInt(subtotal) + parseInt(split['2'])
            $('#total').text('Rp' + total)
        })
    </script>
@endsection