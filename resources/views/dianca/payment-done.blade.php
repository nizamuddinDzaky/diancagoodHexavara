@extends('layouts.store')

@section('title')
<title>Selesaikan Pembayaran</title>
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            <div class="row my-2">
                <div class="main_title">
                    <h2 class="pl-4">Selesaikan Pembayaran</h2>
                </div>
            </div>
            <div class="row pt-2 pl-2">
                <div class="col-lg-7">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h5 class="pl-3 text-gray-3 weight-600">Nomor Pemesanan</h5>
                            <h4 class="pl-3 pb-2 text-orange"><strong>DG001228122020AV</strong></h4>
                            <h5 class="pl-3 text-gray-3 weight-600">Metode Pembayaran</h5>
                            <h5 class="pl-3 pb-2 text-gray-2 weight-600">Transfer Bank BNI</h5>
                            <h5 class="pl-3 text-gray-3 weight-600">Nomor Rekening</h5>
                            <h5 class="pl-3 pb-2 text-gray-2 weight-600">800 152 6846<span class="text-orange float-right">Salin</span></h5>
                            <h5 class="pl-3 text-gray-3 weight-600">Atas Nama</h5>
                            <h5 class="pl-3 pb-2 text-gray-2 weight-600">Toko Diancagoods</h5>
                            <h5 class="pl-3 text-gray-3 weight-600">Batas Pembayaran</h5>
                            <h5 class="pl-3 pb-2 text-gray-2 weight-600">Senin, 29 Desember 2020. Pukul 10:21 WIB</h5>
                            <hr>
                            <h5 class="pl-3 text-gray-3 weight-600">Total Pembayaran</h5>
                            <h3 class="pl-3 text-gray-2 weight-600">Rp 287.002<span class="text-orange float-right font-16">Salin</span></h3>
                            <h6 class="pl-3 pb-3">Transfer tepat sampai 2 digit terakhir agar mempercepat proses verifikasi</h6>
                            <div class="pl-3">
                                <a type="button" class="btn btn-outline-orange btn-block font-18" href="#" aria-disabled="true" data-toggle="modal" data-target="#uploadPaymentModal">Upload Bukti Pembayaran</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h4 class="weight-600">Petunjuk Pembayaran</h4>
                            <hr>
                            <div class="option">
                                <h5 class="text-gray-2 py-0">ATM BNI</h5>
                                <i class="material-icons md-18 float-right">keyboard_arrow_up</i>
                            </div>
                            <hr>
                            <div class="option">
                                <h5 class="text-gray-2 py-0">BNI Mobile</h5>
                                <i class="material-icons md-18 float-right">keyboard_arrow_up</i>
                            </div>
                            <ol class="option-text text-gray-3 font-14">
                                <li>Akses BNI Mobile Banking dari handphone kemudian masukkan user ID dan password</li>
                                <li>Pilih menu “Transfer”</li>
                                <li>Pilih menu “Transfer Antar BNI”</li>
                                <li>Pilih Input Baru</li>
                                <li>Masukkan Rekening Tujuan (041526846515)</li>
                                <li>Masukkan Nominal sesuai dengan Total Pembayaran</li>
                                <li>Masukkan Password Transaksi</li>
                                <li>Jika berhasil, simpan Bukti Pembayaran</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade w-100" id="uploadPaymentModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header pl-0 pb-4">
                <h3 class="modal-title w-100 text-center position-absolute" style="color: black">Bukti Pembayaran</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="cart_inner">
                        <form action="">
                            <div class="form-group pl-2 pr-2">
                                <label style="color: #4F4F4F">Nomor Pemesanan</label><br>
                                <input type="text" name="nomorpemesanan" id="nomorpemesanan" class="form-control" style="background: #F2F2F2" placeholder="DG01232020AV" disabled>
                            </div>
                            <div class="form-group pl-2 pr-2 pb-1">
                                <label style="color: #4F4F4F">Bank Tujuan</label>
                                <select class="form-control border" style="boder-color: #EOEOEO">
                                    <option>Bank BNI (800 152 6846) - A/n. Toko Diancagoods</option>
                                </select>
                            </div>
                            <div class="form-group pl-2 pr-2 pb-1">
                                <label style="color: #4F4F4F">Bank Pengirim</label>
                                <select class="form-control border" style="boder-color: #EOEOEO;">
                                    <option>Pilih Bank</option>
                                </select>
                            </div>
                            <div class="form-group pl-2 pr-2 pb-1">
                                <label style="color: #4F4F4F">Nomor Rekening Pengirim</label>
                                <input type="text" class="form-control border" style="boder-color: #EOEOEO" id="norekpengirim" placeholder="" required>
                            </div>
                            <div class="form-group pl-2 pr-2 pb-1">
                                <label style="color: #4F4F4F">Nama Pemilik Rekening</label>
                                <input type="text" class="form-control border" style="boder-color: #EOEOEO" id="narekpengirim" placeholder="" required>
                            </div>
                            <div class="form-group pl-2 pr-2 pb-1">
                                <label style="color: #4F4F4F">Jumlah Transfer</label><br>
                                <input type="text" name="jumlahtrf" id="jumlahtrf" class="form-control border" style="boder-color: #EOEOEO" required>
                            </div>
                            <div class="form-group pl-2 pr-2 pb-1">
                                <label style="color: #4F4F4F">Tanggal Transfer</label><br>
                                <input type="text" name="tgltrf" id="tgltrf" class="form-control border" style="boder-color: #EOEOEO" placeholder="29 Desember 2020" required>
                            </div>
                        </form>
                    </div>
                    <div class="row float-right">
                        <div class="col-md-12">
                            <div class="cart-inner">
                                <div class="out_button_area">
                                    <div class="checkout_btn_inner">
                                        <a class="btn btn-outline-secondary" style="width: 7rem; height:40px" href="#" data-dismiss="modal">Cancel</a>
                                        <a class="btn btn-outline-orange bg-orange" style="color: white" href="#">Upload</a>
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
@endsection

@section('js')
<script>

</script>
@endsection