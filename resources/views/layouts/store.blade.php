<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.min.js"></script>
    @yield('css')

</head>

<body>
<header class="header_area">
        <div class="container-fluid overflow-visible-2">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand logo_h pr-3" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo-1x.png') }}" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#category-search"
                    aria-controls="category-search" aria-expanded="false" aria-label="Toggle navigation"><i
                        class="material-icons md-24">menu</i>
                </button>
                <div class="collapse navbar-collapse" id="category-search">
                    <ul class="navbar-nav d-flex mx-auto nav-fill w-100">
                        <li class="nav-item h-100">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">Kategori</a>
                            <div class="dropdown-menu">
                                @forelse($categories as $c)
                                <a class="dropdown-item"
                                    href="{{ route('category-result', $c->id) }}">{{ $c->name }}</a>
                                @empty
                                @endforelse
                            </div>
                        </li>
                        <li class="nav-item h-100 search_bar">
                            <form action="{{ route('filter-product') }}" method="get"
                                class="form-inline d-inline w-100" id="form-search-navbar">
                                <input type="hidden" name="categoryFilter" id="input-hidden-category">
                                <input type="hidden" name="categoryBrand" id="input-hidden-brand">
                                <input type="hidden" class="form-control" id="min-price-hide" name="min-price" placeholder="Minimum" value="{{ app('request')->input('min-price') ?? '0' }}">
                                <input type="hidden" class="form-control" id="max-price-hide" name="max-price" placeholder="Maksimum" value="{{ app('request')->input('max-price') ?? '0' }}">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="param" placeholder="Search" id="input-search-navbar"
                                        aria-label="Search" value="{{ request()->param }}">
                                    <div class="input-group-append">
                                        <!-- <div class="input-group-text py-0"> -->
                                            <a type="button" class="input-group-text float-right muted" id="search-navbar"><i class="material-icons md-24 py-0">search</i></a>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </form>

                        </li>
                        <li class="nav-item align-self-center h-100">
                            @if (!auth()->guard('customer')->check() || (!auth()->guard('customer')->user()->cart))
                            <a type="button" class="nav-link nav_btn" href="{{ route('cart.show') }}" tabindex="-1"
                                aria-disabled="true"><i class="material-icons md-18">shopping_cart</i></a>
                            @elseif (auth()->guard('customer')->check() && (auth()->guard('customer')->user()->cart))
                            <a type="button" class="nav-link nav_btn" href="{{ route('cart.show') }}" tabindex="-1"
                                aria-disabled="true"><i class="material-icons md-18">shopping_cart</i><span
                                    class="badge badge-pill badge-orange"
                                    id="cart_qty">{{ auth()->guard('customer')->user()->cart->details->sum('qty') ?? '0'}}</span></a>
                            @endif
                        </li>
                        @if (auth()->guard('customer')->check())
                        <li class="nav-item h-100">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">{{ Auth::guard('customer')->user()->name }}</a>
                            <div class="dropdown-menu">
                                <a href="{{ route('profile') }}" class="dropdown-item">Edit Profil</a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('transaction.list', 5) }}" class="dropdown-item">Pembelian<span class="badge badge-orange ml-2">2</span></a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('reviews.list') }}" class="dropdown-item">Ulasan</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" style="color:#EB5757"
                                    href="{{ route('customer.logout') }}">Keluar</a>
                            </div>
                        </li>
                        @else
                        <li class="nav-item align-self-center h-100 nav_btn">
                            <a type="button" class="btn btn-outline-orange"
                                href="{{ route('customer.login') }}">Masuk</a>
                        </li>
                        <li class="nav-item align-self-center h-100 nav_btn">
                            <a type="button" class="btn py-0" href="{{ route('customer.register') }}">Daftar</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>


    {{-- Success Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- Error Alert --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{session('error')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @yield('content')

    <!-- Footer -->
    <footer class="page-footer font-small py-4 px-4">
        <div class="container-fluid text-center text-md-left text-gray-2">
            <div class="row">
                <div class="col-md-3 mt-md-0 justify-content-center">
                    <a class="navbar-brand logo_h2 m-0" href="{{ url('/') }}">
                        <img src="{{ asset('img/logo-1x.png') }}" alt="logo">
                    </a>
                    <hr class="clearfix w-100 d-md-none pb-3">
                </div>
                <div class="col-md-3 mb-md-0 mb-3">
                    <h5 class="text-uppercase weight-600">CUSTOMER CARE</h5>
                    <ul class="list-unstyled">
                        <li><a href="#!" class="weight-600 text-orange">FAQ</a></li>
                        <li><a href="#!" class="weight-600 text-orange">How to Order</a></li>
                        <li><a href="#!" class="weight-600 text-orange">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-md-0 mb-3">
                    <h5 class="text-uppercase weight-600">ABOUT US</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about-us') }}" class="weight-600 text-orange">Tentang DiancaGoods</a></li>
                        <li><a href="{{ route('term-condition') }}" class="weight-600 text-orange">Terms & Condition</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-md-0 mb-3">
                    <h5 class="text-uppercase weight-600">DAFTAR UNTUK INFO TERBARU</h5>
                    <ul class="list-unstyled">
                        <li>
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control border-1" type="text" placeholder="Email" aria-label="Email" name="email">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-3 border-1" id="basic-text1">Daftar</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="footer-bottom">
                            <h5 class="text-uppercase weight-600">Media Sosial</h5>
                            <div class="btn-toolbar footer-social">
                                <a><img style="width:1.5rem; margin-right:1rem;"
                                            src="{{ asset('img/fb.png') }}"></a>
                                <a><img style="width:1.5rem;margin-right:1rem;"
                                            src="{{ asset('img/ig.png') }}"></a>
                                <a><img style="width:1.5rem;"
                                            src="{{ asset('img/yt.png') }}"></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center py-3">Copyright ©2020 DiancaGoods</div>
    </footer>
    @section('js')
    @endsection

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/core.js') }}"></script>
    @yield('js')
</body>

</html>