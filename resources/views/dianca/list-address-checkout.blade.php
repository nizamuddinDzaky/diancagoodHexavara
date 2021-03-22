@foreach($address as $var)

    <div class="col-md-12 shadow p-3 mb-5 bg-white rounded content-custom" style="cursor: default !important;">

        <div class="row">
            <div class="col-md-9">
                <div class="heading">
                    <h5> <a href="{{ route('checkout.change-address', ['id' => $var->id]) }}" class="text-body"><strong>{{ $var->receiver_name }}</strong> ({{ $var->address_type }} )</a> </h5>
                </div>
            </div>
            <div class="col-md-3">
            	<div class="text-right">
            		@if ($var->is_main != 1)
                    <a href="javascript:void(0)" class="text-orange delete-address" data-url-delete="{{ route('profile-address.delete', ['id' => $var->id]) }}" data-address-type="{{ $var->address_type }}">
                        <i class="material-icons md-18">delete</i>
                    </a>
                    @endif
	            </div>
	        </div>
		</div>
		<div class="row col-md-12">
            <p id="receiver_phone_main" style="margin: 0">{{ $var->receiver_phone }}</p>
		</div>
		<!-- <div class="row my-2 pl-3" style="color: #333333"> -->
        <!-- </div> -->
        <div class="row col-md-12">
        	<p><a href="javascript:void(0)" class="text-muted">{{ $var->address }} , {{ $var->district->city->type }} {{ $var->district->city->name }}, , {{ $var->postal_code }}</a></p>
        </div>

        <div class="text-right">
            <a href="javascript:void(0)"  class="text-orange update-alamat" data-url-edit="{{ route('profile-address.edit', $var->id) }}" data-url-detail="{{ route('address.detail') }}" data-id="{{ $var->id }}">Perbarui Alamat</a>
        </div>
    </div>
</div>
@endforeach