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
                        <h2 class="pl-3">Pembayaran</h2>
                        <h5 class="pl-3 pt-2">2 dari 2 langkah</h5>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-4">
                        <hr class="rounded" style="border: 5px solid orange">
                        <h6>1 Checkout</h6>
                    </div>
                    <div class="col-lg-4">
                        <hr class="rounded" style="border: 5px solid orange">
                        <h6>2 Bayar</h6>
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
                            <div class="col-lg-12 pb-2">
                                <div class="card shadow-1" style="width: 47rem">
                                    <div class="card-body">
                                        <form action="">
                                            <div class="form-group">
                                                <label>Pilih Metode Pembayaran</label><br>
                                                <select id="inputState" class="form-control" style="background: #F2F2F2">
                                                    <option selected>Bank Transfer</option>
                                                    <option>...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Bank</label><br>
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
                                            <h4><strong>Ringkasan Belanja</strong></h4>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <hr class="" style="border-color:F2F2F2">
                                    </div>
                                    <div class="row px-4 py-2">
                                        <div class="col-lg-6">
                                            <div class="row ml-2">
                                                <h5>Total Harga</h5>
                                            </div>
                                            <div class="row ml-2 pt-1 pb-2">
                                                <h5>Ongkos Kirim</h5>
                                            </div>
                                            <div class="row ml-2 pt-3">
                                                <h5>Total Tagihan</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mr-2 float-right">
                                                <h5>Rp {{number_format($total_cost, 2, ',', '.')}}</h5>
                                            </div>
                                            <div class="row mr-2 pt-1 pb-2 float-right">
                                                <h5>Rp {{ number_format(17000, 2, ',', '.') }}</h5>
                                            </div>
                                            <br>
                                            <div class="row mr-2 pt-3 float-right">
                                                <h5><strong>Rp {{number_format($total_cost + 17000, 2, ',', '.')}}</strong></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center pt-4">
                                        <a type="button" class="btn btn-outline-orange bg-orange" style="color: white; width:20rem" href="{{ route('payment.done', $id) }}" aria-disabled="true">Bayar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>