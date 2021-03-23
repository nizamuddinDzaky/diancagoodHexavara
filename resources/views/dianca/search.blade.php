@extends('layouts.store')

@section('title')
<title>DiancaGoods</title>
@endsection

@section('content')
<section class="">
    <div class="">
        <div class="container-fluid">
            <div class="row my-2 pb-4 pt-4 pl-2">
                <div class="main_title">
                    <h2 style="color: white">SEARCH</h2>
                </div>
            </div>
            <div class="row my-2 pb-2 pt-2 pl-2">
                <div class="col-lg-5">
                    @if ($str != NULL)
                    <h5>Menampilkan hasil pencarian produk untuk "{{ $str }}"</h5>
                    @endif
                </div>
                <div class="col-lg-5"></div>
                <div class="col-lg-2 float-right">
                    <button class="btn dropdown-toggle border" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Urutkan: Paling Sesuai
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Paling Banyak Dibeli</a>
                        <a class="dropdown-item" href="#">Termurah</a>
                        <a class="dropdown-item" href="#">Termahal</a>
                    </div>
                </div>
            </div>
            <div class="row my-2 pb-2 pt-3">
                <div class="col-lg-3 pb-3">
                    <div class="card shadow-1">
                        <!-- <form action="{{ route('filter-product') }}"> -->
                            <input type="hidden" name="param" value="{{ request()->param }}" id="input-hidden-param">
                            <div class="card-body">
                                <div class="option">
                                    <h4 class="py-0 weight-600">Kategori Barang</h4>
                                    <i class="material-icons md-18 float-right">keyboard_arrow_up</i>
                                </div>
                                <ul class="option-text text-gray-3 font-14" style="list-style-type:none;">
                                @foreach ($category as $v)
                                    <li class="border-0 {{ in_array($v->id, $arrayFilterCategory) ? 'active' : ''  }} pb-2 pt-2">
                                        <a href="javascript:void(0)" class="option-text text-gray-3 font-14 filter-category" value="{{ $str }}" data-id-category = "{{ $v->id }}"><h5>{{ $v->name }}</h5></a>
                                    </li>
                                @endforeach
                                </ul>
                                
                                <hr>
                                <div class="option">
                                <h4 class="py-0 weight-600">Brand</h4>
                                    <i class="material-icons md-18 float-right">keyboard_arrow_up</i>
                                </div>
                                <ul class="option-text text-gray-3 font-14" style="list-style-type:none;">
                                @foreach ($brand as $val)
                                    <li class="border-0 {{ in_array($val->id, $arrayFilterBrand) ? 'active' : '' }} pb-2 pt-2" value="">
                                        <a href="javascript:void(0)" class="option-text text-gray-3 font-14 hover filter-brand" value="{{ $str }}" data-id-brand = "{{ $val->id }}"><h5>{{ $val->name }}</h5></a>
                                    </li>
                                @endforeach
                                </ul>
                                
                                <hr>
                                <div class="option">
                                <h5 class="py-0 weight-600">Harga</h5>
                                    <i class="material-icons md-18 float-right">keyboard_arrow_up</i>
                                </div>
                                
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="background:#F2F2F2">Min</div>
                                        </div>
                                        <input type="text" class="form-control input-money" id="min-price" name="" placeholder="Minimum" value="{{ app('request')->input('min-price') ?? '0' }}">

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="background:#F2F2F2">Max</div>
                                        </div>
                                        <input type="text" class="form-control input-money" id="max-price" name="" placeholder="Maksimum" value="{{ app('request')->input('max-price') ?? '0' }}">
                                        
                                    </div>
                                </div>
                                <button class="btn btn-orange ml-3 mt-2 text-center" style="width: 15rem" id="btn-apply-filter">Apply</button>
                                
                            </div>
                        <!-- </form> -->

                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row my-2 ml-2">
                        @forelse($product as $row)
                        <div class="col">
                            <div class="f_p_item">
                                <div class="f_p_img ">
                                    <a href="{{ url('/product/' . $row->id) }}">
                                        <img id="pic{{ $row }}" class="home-product-center-cropped"
                                            src="{{ asset('storage/products/' . $row->images->first()->filename) }}"
                                            alt="{{ $row->name }}">
                                    </a>
                                    <div class="p_icon">
                                        <button onclick="addToCart({{ $row->variant->first()->id }})"
                                            class="btn btn-orange ml-2 mt-2 text-center mb-2" style="">+
                                            Keranjang</button>
                                    </div>
                                </div>
                                <a href="{{ url('/product/' . $row->id) }}" class="overflow-auto mb-2">
                                    <h4 class="text-gray-2 product-name" class="pl-3">{{ $row->name }}</h4>
                                </a>
                                @if( $row->variant->first()->promo_price != $row->variant->first()->price )
                                <h5 class="text-gray-1 d-flex justify-content-center">Rp
                                    {{ number_format($row->variant->first()->promo_price) }}<span
                                        class="d-inline-flex align-self-center ml-2"
                                        style="text-decoration:line-through;"><small>Rp
                                            {{ number_format($row->variant->first()->price) }}</small></span></h5>
                                @else
                                @if( number_format($row->variant->first()->price) !=
                                number_format($row->variant->last()->price)
                                )
                                <h5 class="text-gray-1">Rp {{ number_format($row->variant->first()->price) }} - Rp
                                    {{ number_format($row->variant->last()->price) }}</h5>
                                @else
                                <h5 class="text-gray-1">Rp {{ number_format($row->variant->first()->price) }}</h5>
                                @endif
                                @endif
                                @for($i = 0; $i < 5; $i++) @if ($i < $row->rate)
                                    <span class="fa fa-star checked"></span>
                                    @else
                                    <span class="fa fa-star"></span>
                                    @endif
                                    @endfor
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
function addToCart(var_id) {
    if ("{{ auth()->guard('customer')->check() }}") {
        $.ajax({
            url: '/cart/quick-add/' + var_id,
            type: 'GET',
            data: {
                id: var_id
            },
            success: function(res) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    iconColor: '#fff',
                    title: '<h6 style="color:white">Berhasil masuk keranjang!</h6>',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,
                    background: '#f37020'
                })

                console.log(res.qty);
                $("#cart_qty").html(res.qty)
            }
        })
    } else {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: '<h6 style="color:white">Masuk untuk menambahkan ke keranjang!</h6>',
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            background: '#d33',
        }).then(function(e) {
            e.dismiss;
        }, function(dismiss) {
            return false;
        })
    }
}

    var selected_category = @json($arrayFilterCategory);
    var selected_brand = @json($arrayFilterBrand);
    $(document).ready(function () {
        set_value_filter();
        $('#min-price').keyup(function () {
            $('#min-price-hide').val(rupiah_to_int($(this).val())).change();
        })

        $('#max-price').keyup(function () {
            $('#max-price-hide').val(rupiah_to_int($(this).val())).change();
        })

        $('#max-price-hide').change(function () {
            let min = parseInt($('#min-price-hide').val());
            if (min != 0 && $(this).val() > 0) {
                if ($(this).val() < min) {
                    $(this).val(min)
                    $('#max-price').val(min)
                }
            }
        })

        $('#min-price-hide').change(function () {
            let max = parseInt($('#max-price-hide').val());
            if (max != 0 && $(this).val() > 0) {
                if ($(this).val() > max) {
                    $(this).val(max)
                    $('#min-price').val(max)
                }
            }
        })

        $('.filter-category').click(function () {
            
            let parent = $(this).parent();
            let id_category = $(this).data('id-category').toString();

            if ($(parent).hasClass('active')) {
                selected_category = removeA(selected_category, id_category);
                $(parent).removeClass('active');
            }else{
                selected_category.push(id_category)
                $(parent).addClass('active');
            }
            
            set_value_filter()
        })

        $('.filter-brand').click(function () {
            let parent = $(this).parent();
            let id_brand = $(this).data('id-brand').toString();

            if ($(parent).hasClass('active')) {
                selected_brand = removeA(selected_brand, id_brand);
                $(parent).removeClass('active');
            }else{
                selected_brand.push(id_brand)
                $(parent).addClass('active');
            }
            set_value_filter()
        })

        $('#input-search-navbar').change(function(){
            $('#input-hidden-param').val($(this).val());
        });

        $('#btn-apply-filter').click(function(){
            $('#search-navbar').click();
        })
    })

    function set_value_filter() {
        $('#input-hidden-category').val(selected_category);
        $('#input-hidden-brand').val(selected_brand);
    }
</script>
@endsection