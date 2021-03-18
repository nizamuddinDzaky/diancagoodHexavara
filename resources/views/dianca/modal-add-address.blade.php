<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header pl-0 pb-4">
            <h3 class="modal-title w-100 text-center position-absolute" style="color: #333333" id="title-modal"></h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="cart_inner" id="modal-body">
                    <form action="" method="post" id="address-form">
                        @csrf
                        <div class="form-row pl-2 pr-2 pb-3">
                            <div class="form-group col-md-10">
                                <label>Jenis Alamat</label><br>
                                <input type="text" name="address_type" id="address_type" class="form-control"
                                    style="background: #F6F6F6" required>
                                <p class="text ml-1" style="color: #828282">Contoh : Alamat Kantor, Alamat Rumah,
                                    Apartemen</p>
                                <input type="hidden" value="{{ auth()->guard('customer')->user()->id }}" id="customer_id" name="customer_id">
                            </div>
                            <div class="col-md-2 form-check">
                                <label class="form-check-label" for="is_main">
                                    Alamat utama?
                                </label>
                                <input class="form-check-input" type="checkbox" value="1" id="is_main" name="is_main">
                            </div>
                        </div>
                        <div class="form-row pl-2 pr-2 pb-3">
                            <div class="form-group col-md-6">
                                <label>Nama Penerima</label>
                                <input type="text" class="form-control" id="receiver_name" name="receiver_name"
                                    style="background: #F6F6F6" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nomor Telepon</label>
                                <input type="text" class="form-control" id="receiver_phone" name="receiver_phone"
                                    style="background: #F6F6F6" required>
                                <p class="text ml-1" style="color: #828282">Contoh : 081234567890</p>
                            </div>
                        </div>
                        <div class="form-row pl-2 pr-2 pb-3">
                            <div class="form-group col-md-6">
                                <label>Provinsi</label>
                                <select id="province_id" name="province_id" class="form-control bg-light-2">
                                    <option value="" selected>Pilih</option>
                                    @foreach($provinces as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kota/Kabupaten</label>
                                <select id="city_id" name="city_id" class="form-control bg-light-2">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row pl-2 pr-2 pb-3">
                            <div class="form-group col-md-8">
                                <label>Kecamatan</label>
                                <select id="district_id" name="district_id" class="form-control bg-light-2">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kode Pos</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code"
                                    style="background: #F6F6F6" required>
                            </div>
                        </div>
                        <div class="form-group pl-2 pr-2 pb-3">
                            <label>Alamat</label><br>
                            <textarea name="address" id="address" cols="60" rows="4" class="form-control"
                                style="background: #F6F6F6; border: none" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="row float-right">
                    <div class="col-md-12">
                        <div class="cart-inner">
                            <div class="out_button_area">
                                <div class="checkout_btn_inner">
                                    <a id="close-add-address" class="btn btn-outline-gray" data-dismiss="modal">Batal</a>
                                    <a type="submit" class="btn btn-orange weight-600" id="add-address">Simpan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script type="text/javascript">
    
</script>
@endsection