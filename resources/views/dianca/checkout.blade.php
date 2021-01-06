<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Checkout</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
    <header class="header_area">
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid pr-5 pl-5">
                    <a class="navbar-brand logo_h pr-3" href="{{ url('/') }}">
                        <img src="{{ asset('img/logo-1x.png') }}" alt="logo" style="width: 150px">
                    </a>
                </div>
            </nav>
        </div>
    </header>
    <section class="feature_product_area section_gap mt-4" style="height: 240px">
        <div class="main_box pt-4">
            <div class="container">           
                <div class="row my-2">
                    <div class="main_title">
                        <h2 class="pl-3" style="color: black">Pembayaran</h2>
                        <h5 class="pl-3 pt-2" style="color: black">1 dari 2 langkah</h5>
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
            <div class="container">
                <div class="row my-2">
                    <div class="main_title">
                        <h3 class="pl-3" style="color: black">Alamat Pengiriman</h3>
                    </div>
                </div>
                <div class="row my-2 pb-3">
                    <div class="col">
                        <a type="button" class="btn btn-outline-orange" href="#" aria-disabled="true" data-toggle="modal" data-target="#addressModal">Buat Alamat Baru</a>
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
            <div class="container">
                <div class="row pt-2 pl-2">
                    <div class="col-lg-8">
                        <div class="row py-2">
                            <div class="col-lg-12 pb-1">
                                <div class="card shadow-1" style="width: 47rem">
                                    <div class="row px-4 py-4">
                                        <div class="col-lg-3">
                                            <a href="#">
                                                <img id="image" class="product-img-sm" src="img/Aha Bha Pha Miracle AC SOS Starterkit 1.png" alt="Starterkit">
                                            </a>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row ml-2 pt-3">
                                                <a href="#">
                                                    <h4 style="color: black">STARTERKIT AHA BHA PHA Miracle AC SOS Starterkit</h4>
                                                </a>
                                            </div>
                                            <div class="row ml-2 pt-2">
                                                <h5 style="color: black">1 Barang (2kg)</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <hr class="" style="border-color:F2F2F2">
                                    </div>
                                    <div class="row px-4 py-2" style="height: 60px">
                                        <div class="col-lg-9">
                                            <h5 class="ml-2" style="color: black">Sub Total Harga: <strong>Rp 270.000</strong></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <a type="button" class="btn btn-outline-orange float-right" href="#" aria-disabled="true">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <hr class="" style="border-color:F2F2F2">
                        </div>
                        <div class="row py-2 ml-2 pb-4">
                            <div class="col-lg-6">
                                <div class="main_title pb-2">
                                    <h4 style="color: black">Pengiriman</h4>
                                </div>
                                <div class="form-group">
                                    <label style="color: black">Pilih Jasa Pengiriman</label><br>
                                    <select id="inputState" class="form-control border border-dark" style="width:8rem">
                                        <option selected>JNT</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="color: black">Pilih Durasi</label><br>
                                    <select id="inputState" class="form-control border border-dark" style="width:12rem">
                                        <option selected>Regular (4-5 hari)</option>
                                        <option>...</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="main_title pb-2 ml-2">
                                    <h4 style="color: black">Ringkasan Pengiriman</h4>
                                </div>
                                <div class="row px-4 py-2">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <h6 style="color: black">Jasa Pengiriman</h6>
                                            </div>
                                            <div class="row pt-1">
                                                <h6 style="color: black">Durasi</h6>
                                            </div>
                                            <div class="row pt-1">
                                                <h6 style="color: black">Estimasi Tiba</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <h6 style="color: black">JNT (Regular)</h6>
                                            </div>
                                            <div class="row pt-1">
                                                <h6 style="color: black">4 - 5 hari</h6>
                                            </div>
                                            <div class="row pt-1">
                                                <h6 style="color: black">24 - 25 Desember 2020</h6>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row py-2">
                            <div class="col-lg-12 pb-4">
                                <div class="card shadow-1" style="width: 22rem; height:20rem">
                                    <div class="row px-4 py-4 ml-2" style="height: 50px">
                                        <div class="">
                                            <h4 style="color: black"><strong>Ringkasan Belanja</strong></h4>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <hr class="" style="border-color:F2F2F2">
                                    </div>
                                    <div class="row px-4 py-2">
                                        <div class="col-lg-6">
                                            <div class="row ml-2">
                                                <h5 style="color: black">Total Harga</h5>
                                            </div>
                                            <div class="row ml-2 pt-1 pb-2">
                                                <h5 style="color: black">Ongkos Kirim</h5>
                                            </div>
                                            <div class="row ml-2 pt-3">
                                                <h5 style="color: black">Total Tagihan</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mr-2 float-right">
                                                <h5 style="color: black">Rp 270.000</h5>
                                            </div>
                                            <div class="row mr-2 pt-1 pb-2 float-right">
                                                <h5 style="color: black">Rp 17.000</h5>
                                            </div>
                                            <br>
                                            <div class="row mr-2 pt-3 float-right">
                                                <h5 style="color: black"><strong>Rp 287.000</strong></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center pt-4">
                                        <a type="button" class="btn btn-outline-orange bg-orange" style="color: white; width:20rem" href="{{ route('payment') }}" aria-disabled="true">Pilih Pembayaran</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade w-100" id="addressModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header pl-0 pb-4">
                    <h3 class="modal-title w-100 text-center position-absolute" style="color: black">Buat Alamat Baru</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="cart_inner">
                            <form action="">
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label style="color: black">Jenis Alamat</label><br>
                                    <input type="text" name="alamat" id="jenisalamat" class="form-control border border-dark" placeholder="Alamat Rumah" required>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-6">
                                        <label style="color: black">Nama Penerima</label>
                                        <input type="text" class="form-control border border-dark" id="receiver" placeholder="Rana Wijan Naim">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label style="color: black">Nomor Telepon</label>
                                        <input type="text" class="form-control border border-dark" id="phone" placeholder="081234567890">
                                    </div>
                                </div>
                                <div class="form-row pl-2 pr-2 pb-3">
                                    <div class="form-group col-md-8">
                                        <label style="color: black">Kota atau Kecamatan</label>
                                        <input type="text" class="form-control border border-dark" id="kota" placeholder="Patienworo, Kab. Nganjuk">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label style="color: black">Kode Pos</label>
                                        <input type="text" class="form-control border border-dark" id="kodepos" placeholder="64391">
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 pb-3">
                                    <label style="color: black">Alamat</label><br>
                                    <input type="text" name="alamat" id="alamat" class="form-control border border-dark" required>
                                </div>
                            </form>
                        </div>
                        <div class="row float-right">
                            <div class="col-md-12">
                                <div class="cart-inner">
                                    <div class="out_button_area">
                                        <div class="checkout_btn_inner">
                                            <a class="btn btn-outline-secondary" style="width: 7rem; height:40px" href="#">Batal</a>
                                            <a class="btn btn-outline-orange bg-orange" style="color: white" href="#">Tambah</a>
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
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>