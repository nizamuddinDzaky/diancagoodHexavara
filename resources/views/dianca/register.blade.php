<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="align-items-center d-flex min-vh-100">
        <div class="container-fluid pt-5 mt-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-1"></div>
                <div class="col-lg-5 md-5 sm-5 pt-5">
                    <div class="container my-auto">
                        <div>
                            <img class="" src="{{ asset('img/register.png') }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-5 md-5 sm-5 pt-5">
                    <div class="card shadow-1 my-auto pt-2" style="width: 85%">
                        <div class="card-body">
                            <h3 class="card-title text-center pb-1"><strong>Daftar akun baru</strong></h3>
                            <h6 class="card-subtitle mb-2 text-muted text-center">Lorem ipsum is simply dummy text</h6>
                            <form action="" class="form pl-3 pr-3 pt-4" id="register-form" method="post">
                                <div class="form-group">
                                    <label>Nama</label><br>
                                    <input type="text" name="name" id="name" class="form-control bg-light" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label><br>
                                    <input type="text" name="email" id="email" class="form-control bg-light" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label><br>
                                    <input type="password" name="password" id="password" class="form-control bg-light"
                                        required>
                                </div>
                                <div class="form-group pt-4 text-center">
                                    <input type="submit" value="Daftar Sekarang" name="register_submit"
                                        id="register_submit" class="form-control form-control-lg bg-orange"
                                        style="color: white">
                                    <label class="text-muted text-center pt-2">Sudah punya akun? <a href="{{ route('customer.login') }}"
                                            style="color:orange;font-weight:bold">Masuk Sekarang</a></label><br>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
