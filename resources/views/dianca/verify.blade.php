<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi</title>

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
                            <h3 class="card-title text-center pb-1"><strong>Verifikasi Kode</strong></h3>
                            <h6 class="card-subtitle mb-2 text-muted text-center">Masukkan kode verifikasi yang
                                dikirimkan</h6>
                            <h6 class="card-subtitle mb-2 text-muted text-center">pada email anda</h6>
                            <form action="" class="form pt-4 justify-content-center" id="verify-form"
                                method="post">
                                <h5 class="text-center pt-3">Kode Verifikasi</h5>
                                <h6 class="text-center" style="color:orange"><strong>04:59</strong></h6>
                                <div class="form-row justify-content-center py-3">
                                    <!-- <div class="col-lg-2 md-2 sm-2"></div> -->
                                    <!-- <div class="col-xs-1"></div> -->
                                    <div class="form-group col-lg-1 md-1 sm-1 mr-4">
                                        <input type="text" maxLength="1" size="1" min="0" max="9"
                                            class="form-control rounded border border-orange"
                                            style="height: 60px; width: 50px">
                                    </div>
                                    <!-- <div class="col-lg-1 md-1 sm-1"></div> -->
                                    <div class="form-group col-lg-1 md-1 sm-1 mr-4">
                                        <input type="text" maxLength="1" size="1" min="0" max="9"
                                            class="form-control rounded border border-orange"
                                            style="height: 60px; width: 50px">
                                    </div>
                                    <!-- <div class="col-lg-1 md-1 sm-1"></div> -->
                                    <div class="form-group col-lg-1 md-1 sm-1 mr-4">
                                        <input type="text" maxLength="1" size="1" min="0" max="9"
                                            class="form-control rounded border border-orange"
                                            style="height: 60px; width: 50px">
                                    </div>
                                    <!-- <div class="col-lg-1 md-1 sm-1"></div> -->
                                    <div class="form-group col-lg-1 md-1 sm-1 mr-4">
                                        <input type="text" maxLength="1" size="1" min="0" max="9"
                                            class="form-control rounded border border-orange"
                                            style="height: 60px; width: 50px">
                                    </div>
                                </div>
                                <div class="form-group pt-4 text-center">
                                    <input type="submit" value="Verifikasi" name="register_submit" id="register_submit"
                                        class="form-control form-control-lg bg-orange" style="color: white">
                                    <label class="text-muted text-center pt-2">Tidak menerima kode? <a href="#"
                                            style="color:orange">Kirim ulang</a></label><br>
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
