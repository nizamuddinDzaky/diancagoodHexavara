<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pembayaran</title>

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
                        <h2 class="pl-4" style="color: black">Selesaikan Pembayaran</h2>
                    </div>
                    <div class="main_box">
                        <div class="container">
                            <div class="row pt-2 pl-2">
                                <div class="col-lg-8">
                                    <div class="row py-2">
                                        <div class="col-lg-12 pb-2">
                                            <div class="card shadow-1" style="width: 35rem">
                                                <div class="card-body">
                                                    <h5 class="pl-3">Nomor Pemesanan</h5>
                                                    <h4 class="pl-3 pb-2" style="color: #eb7c32"><strong>DG001228122020AV</strong></h4>
                                                    <h5 class="pl-3">Metode Pembayaran</h5>
                                                    <h5 class="pl-3 pb-2" style="color: black">Transfer Bank BNI</h5>
                                                    <h5 class="pl-3">Nomor Rekening</h5>
                                                    <h5 class="pl-3 pb-2" style="color: black">800 152 6846</h5>
                                                    <h5 class="pl-3">Atas Nama</h5>
                                                    <h5 class="pl-3 pb-2" style="color: black">Toko Diancagoods</h5>
                                                    <h5 class="pl-3">Batas Pembayaran</h5>
                                                    <h5 class="pl-3 pb-2" style="color: black">Senin, 29 Desember 2020. Pukul 10:21 WIB</h5>
                                                    <div class="container">
                                                        <hr class="" style="border-color:F2F2F2">
                                                    </div>
                                                    <h5 class="pl-3">Total Pembayaran</h5>
                                                    <h3 class="pl-3" style="color: black"><strong>Rp 287.002</strong></h3>
                                                    <h6 class="pl-3 pb-3">Transfer tepat sampai 2 digit terakhir agar mempercepat proses verifikasi</h6>
                                                    <div class="pl-3">
                                                        <a type="button" class="btn btn-outline-orange" href="#" aria-disabled="true" style="width: 30rem">Upload Bukti Pembayaran</a>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row py-2">
                                        <div class="col-lg-12 pb-4">
                                            <div class="card shadow-1" style="width: 26rem">
                                                <div class="row px-4 py-4 ml-2" style="height: 50px">
                                                    <div class="">
                                                        <h4 style="color: black"><strong>Petunjuk Pembayaran</strong></h4>
                                                    </div>
                                                </div>
                                                <div class="container">
                                                    <hr class="" style="border-color:F2F2F2">
                                                </div>
                                                <div class="row px-4 py-2">
                                                    <div class="col-lg-12">
                                                        <div class="row ml-2">
                                                            <h5 style="color: black">ATM BNI</h5>
                                                        </div>
                                                        <div class="container">
                                                            <hr class="" style="border-color:F2F2F2">
                                                        </div>
                                                        <div class="row ml-2 pt-1 pb-2">
                                                            <h5 style="color: black">BNI Mobile</h5>
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
                </div>
            </div>
        </div>
    </section>
    <section class="feature_product_area">
        <!-- <div class="main_box">
            <div class="container">
                <div class="row pt-2 pl-2">
                    <div class="col-lg-8">
                        <div class="row py-2">
                            <div class="col-lg-12 pb-2">
                                <div class="card shadow-1" style="width: 47rem">
                                    <div class="card-body">
                                        <form action="">
                                            <div class="form-group">
                                                <label style="color: black">Pilih Metode Pembayaran</label><br>
                                                <select id="inputState" class="form-control" style="background: #F2F2F2">
                                                    <option selected>Bank Transfer</option>
                                                    <option>...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label style="color: black">Pilih Bank</label><br>
                                                <select id="inputState" class="form-control" style="background: #F2F2F2">
                                                    <option selected>Bank Negara Indonesia</option>
                                                    <option>...</option>
                                                </select>
                                            </div>
                                        </form>
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
                                        <a type="button" class="btn btn-outline-orange bg-orange" style="color: white; width:20rem" href="#" aria-disabled="true">Bayar (1)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </section>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>