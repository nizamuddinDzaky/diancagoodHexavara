@extends('layouts.store')

@section('title')
<title>Selesaikan Pembayaran</title>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
<section class="section_gap mt-4">
    <div class="main_box pt-4">
        <div class="container text-gray-2">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row mb-2">
                <div class="main_title">
                    <h2>Selesaikan Pembayaran</h2>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-lg-7 col-12 py-2">
                    <div class="card shadow-1">
                        <div class="card-body">
                            <h5 class="text-gray-3 weight-600">Nomor Pemesanan</h5>
                            <h4 class=pb-2 text-orange"><strong>{{ $order->invoice }}</strong></h4>
                            <h5 class="text-gray-3 weight-600">Metode Pembayaran</h5>
                            <h5 class=pb-2 text-gray-2 weight-600">{{ $order->payment->method }}</h5>
                            <h5 class="text-gray-3 weight-600">Nomor Rekening</h5>
                            <h5 class=pb-2 text-gray-2 weight-600"><span class="item-copy" id="span-rekening">800 152 6846</span><span class="text-orange float-right copy-to-clipboart" style="cursor: pointer;" onclick="copy_to_clipboard('span-rekening')">Salin</span></h5>
                            <h5 class="text-gray-3 weight-600">Atas Nama</h5>
                            <h5 class=pb-2 text-gray-2 weight-600">Toko Diancagoods</h5>
                            <h5 class="text-gray-3 weight-600">Batas Pembayaran</h5>
                            <h5 class=pb-2 text-gray-2 weight-600">{{ $order->invalid_at }}</h5>
                            <hr>
                            <h5 class="text-gray-3 weight-600">Total Pembayaran</h5>
                            <input type="hidden" id="input-hidden-total-pembayaran" value="{{ $order->total_cost }}">
                            <h3 class="text-gray-2 weight-600"><span id="span-total-pembayaran">Rp {{ number_format($order->total_cost, 2, ',', '.') }}</span><span class="text-orange float-right font-16" style="cursor: pointer;" onclick="copy_to_clipboard('span-total-pembayaran')">Salin</span></h3>
                            <h6 class="pl-3 pb-3">Transfer tepat sampai 2 digit terakhir agar mempercepat proses verifikasi</h6>
                            @if(strtotime(date('Y-m-d H:i:s')) < strtotime($order->invalid_at))
                            <div>
                                <a type="button" class="btn btn-outline-orange btn-block font-18" href="#" aria-disabled="true" data-toggle="modal" data-target="#uploadPaymentModal">Upload Bukti Pembayaran</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-12 py-2">
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
                        <form action="{{ route('payment.done.process') }}" method="POST" id="payment-done-form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group px-2">
                                <label style="color: #4F4F4F">Nomor Pemesanan</label><br>
                                <input type="text" name="invoice" id="invoice" class="form-control disabled-field" value="{{ $order->invoice }}" readonly>
                                <input type="hidden" name="order_id" id="order_id" class="form-control disabled-field" value="{{ $order->id }}" readonly>
                            </div>
                            <div class="form-group px-2 pb-1">
                                <label style="color: #4F4F4F">Bank Tujuan</label>
                                <select class="form-control border" name="transfer_to" style="border-color: #EOEOEO">
                                    <option value="{{ $order->payment->transfer_to }}" selected>Bank BNI (800 152 6846) - A/n. Toko Diancagoods</option>
                                </select>
                            </div>
                            <div class="form-group px-2 pb-1">
                                <label style="color: #4F4F4F">Bank Pengirim</label>
                                <select class="form-control border" name="transfer_from_bank" id="transfer_from_bank" style="border-color: #EOEOEO;">
                                    <option>Pilih Bank</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BCA">BCA</option>
                                </select>
                            </div>
                            <div class="form-group px-2 pb-1">
                                <label style="color: #4F4F4F">Nomor Rekening Pengirim</label>
                                <input type="text" class="form-control border" name="transfer_from_account" id="transfer_from_account" required>
                            </div>
                            <div class="form-group pl-2 pr-2 pb-1">
                                <label style="color: #4F4F4F">Nama Pemilik Rekening</label>
                                <input type="text" class="form-control border" name="name" id="name" required>
                            </div>
                            <div class="form-group px-2 pb-1">
                                <label style="color: #4F4F4F">Jumlah Transfer</label><br>
                                <div class="input-group">
                                    <!-- <div class="input-group-prepend">
                                        <div class="input-group-text bg-3 border">Rp</div>
                                    </div> -->
                                    <input type="text" id="amount" class="form-control bg-white border input-money" required maxlength="24">
                                    <input type="hidden" name="amount" id="amount-hide" class="form-control bg-white border" required>
                                </div>
                            </div>
                            <div class="form-group px-2 pb-1">
                                <label style="color: #4F4F4F">Tanggal Transfer</label><br>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <input type="text" class="form-control border" name="date" id="date" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="material-icons md-18">calendar_today</i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group px-2 pb-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="proof" name="proof" accept="image/*">
                                    <label class="custom-file-label" for="proof">[OPSIONAL] Upload Foto Bukti</label>
                                </div>
                            </div>  
                        </form>
                    </div>
                    <div class="row float-right">
                        <div class="col-md-12">
                            <div class="cart-inner">
                                <div class="out_button_area">
                                    <div class="checkout_btn_inner">
                                        <a class="btn btn-outline-gray" href="" data-dismiss="modal">Batal</a>
                                        <a id="submit_btn" type="button" class="btn btn-orange weight-600">Upload</a>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    // $('.copy-to-clipboart').click(function () {
    //     let elm = $(this).parent().find('.item-copy');
    //     console.log($(elm))
    //     console.log(document.getElementById("span-rekening"));
    //     copy_to_clipboard(document.getElementById("span-rekening"));
    // })
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#amount').keyup(function () {
        $('#amount-hide').val(rupiah_to_int($(this).val())).change();
    })
    $(function () {
        $('#date').daterangepicker({
            startDate: moment(),
            singleDatePicker: true,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoUpdateInput: true,
            drops: 'up',
        });
    });

    $("#submit_btn").on('click', function(e) {
        e.preventDefault();
        console.log(parseInt($('#amount-hide').val()));
        console.log(parseInt($('#input-hidden-total-pembayaran').val()));
        if (parseInt($('#amount-hide').val()) > parseInt($('#input-hidden-total-pembayaran').val())) {
            Swal.fire({
                title: "Data Tidak Valid",
                text: "Jumlah Transfer Melebihi Total Pembayaran",
                icon: "warning",
                reverseButtons: !0
            }).then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            })
            return false;
        }
        if($("#transfer_from_bank").val() == "" || $("#transfer_from_account").val() == "" || $("#name").val() == "" || $("amount").val() == ""){
            Swal.fire({
                title: "Detail Tidak Lengkap",
                text: "Pastikan semua kolom terisi",
                icon: "warning",
                reverseButtons: !0
            }).then(function (e) {
                e.dismiss;
            }, function (dismiss) {
                return false;
            })
            return false;
        } 
        $("#payment-done-form").submit();
    })
</script>
@endsection