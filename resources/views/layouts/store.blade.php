<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    @yield('title')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('css')

</head>

<body>
    <header class="header_area">
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid pr-5 pl-5">
                    <a class="navbar-brand logo_h pr-3" href="{{ url('/') }}">
                        <img src="{{ asset('img/logo-1x.png') }}" alt="logo" style="width: 150px">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <!-- <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> -->
                    </button>
                    <div class="collapse navbar-collapse offset">
                        <div class="row w-100">
                            <div class="col-lg-2 pl-2">
                                <button class="btn dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Kategori
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Kategori 1</a>
                                    <a class="dropdown-item" href="#">Kategori 2</a>
                                </div>
                            </div>
                            <div class="col-lg-10 pl-2 pr-2">
                                <div class="input-group lg-form form-2 pl-0 pr-3">
                                    <input class="form-control my-0 py-1" type="text" placeholder="Search"
                                        aria-label="Search">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="material-icons md-18">search</i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="nav">
                            <li class="nav-item">
                                <a type="button" class=" btn" href="#" tabindex="-1"
                                    aria-disabled="true"><i class="material-icons md-24">shopping_cart</i></a>
                            </li>
                            <li class="nav-item">
                                <a type="button" class=" btn btn-outline-orange" href="#"
                                    tabindex="-1" aria-disabled="true">Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="page-footer font-small pt-4 pl-5 pr-5">
        <!-- Footer Links -->
        <div class="container-fluid text-center text-md-left">
            <!-- Grid row -->
            <div class="row pl-4">
                <!-- Grid column -->
                <div class="col-md-3 mt-md-0 mt-3">

                    <!-- Content -->
                    <h5 class="text-uppercase"></h5>
                    <p>Logo</p>
                </div>
                <!-- Grid column -->
                <hr class="clearfix w-100 d-md-none pb-3">
                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">
                    <!-- Links -->
                    <h5 class="text-uppercase">CUSTOMER CARE</h5>
                    <ul class="list-unstyled">
                        <li><a href="#!">FAQ</a></li>
                        <li><a href="#!">How to Order</a></li>
                        <li><a href="#!">Contact Us</a></li>
                    </ul>
                </div>
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">
                    <!-- Links -->
                    <h5 class="text-uppercase">ABOUT US</h5>
                    <ul class="list-unstyled">
                        <li><a href="#!">Tentang DiancaGoods</a></li>
                        <li><a href="#!">Term & Condition</a></li>
                    </ul>
                </div>
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">
                    <!-- Links -->
                    <h5 class="text-uppercase">DAFTAR UNTUK INFO TERBARU</h5>
                    <ul class="list-unstyled">
                        <li>
                            <div class="input-group lg-form form-2 pl-0 pr-5">
                                <input class="form-control my-0 py-1 red-border" type="text" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <span class="input-group-text red lighten-3" id="basic-text1">Daftar</span>
                                </div>
                            </div>
                        </li>
                        <br>
                        <li>
                            <h5 class="text-uppercase">SOSIAL MEDIA</h5>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
        <!-- Footer Links -->

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Copyright</div>
        <!-- Copyright -->
    </footer>

    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>

</html>
