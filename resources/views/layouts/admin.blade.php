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
        <div class="container overflow-visible-2">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand logo_h pr-3" href="{{ url('/admin/orders') }}">
                    <img src="{{ asset('img/logo-1x.png') }}" alt="logo">
                </a>
                @if (auth()->guard('web')->check())
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#admin_nav"
                    aria-controls="admin_nav" aria-expanded="false" aria-label="Toggle navigation"><i
                        class="material-icons md-24">menu</i>
                </button>
                <div class="collapse navbar-collapse" id="admin_nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                id="navbarmenu" aria-haspopup="true" aria-expanded="false">Admin</a>
                            <div class="dropdown-menu" aria-labelledby="navbarmenu">
                                <a class="dropdown-item" style="color:#EB5757"
                                    href="{{ route('administrator.logout') }}">Keluar</a>
                            </div>
                        </li>
                    </ul>
                </div>
                @endif
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

    @if (auth()->guard('web')->check())
    <section class="section_gap mt-4 pb-3">
        <div class="main_box pt-4">
            <div class="container-fluid text-gray-2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-toolbar mb-2 admin-menu-group" role="toolbar">
                            <a type="button" id="order" class="btn btn-outline-gray-2 weight-600 admin-menu" href="{{ route('administrator.orders') }}">Order</a>
                            <a type="button" id="product" class="btn btn-outline-gray-2 weight-600 admin-menu" href="{{ route('administrator.products') }}">Produk</a>
                            <a type="button" id="tracking" class="btn btn-outline-gray-2 weight-600 admin-menu" href="{{ route('administrator.tracking', 'all') }}">Tracking</a>
                            <a type="button" id="promo" class="btn btn-outline-gray-2 weight-600 admin-menu" href="{{ route('administrator.promo', 'all') }}">Promo</a>
                            <a type="button" id="report" class="btn btn-outline-gray-2 weight-600 admin-menu" href="{{ route('administrator.all_report') }}">Laporan</a>
                            <a type="button" id="homepage" class="btn btn-outline-gray-2 weight-600 admin-menu" href="{{ route('administrator.homepage') }}">Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @yield('content')

    <section class="section_gap mt-4 pb-3">
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script>
        $(document).ready(function() {
            if(window.location.href.indexOf("/products") > -1) {
                $("#product").addClass('filter-active-2');
            } else if(window.location.href.indexOf("/tracking") > -1) {
                $("#tracking").addClass('filter-active-2');
            } else if(window.location.href.indexOf("/orders") > -1) {
                $("#order").addClass('filter-active-2');
            } else if(window.location.href.indexOf("/promos") > -1) {
                $("#promo").addClass('filter-active-2');    
            }
            else if(window.location.href.indexOf("/report") > -1) {
                $("#report").addClass('filter-active-2');
            }
            else if(window.location.href.indexOf("/homepage") > -1) {
                $("#homepage").addClass('filter-active-2');
            }
        });
    </script>
    @yield('js')
</body>

</html>