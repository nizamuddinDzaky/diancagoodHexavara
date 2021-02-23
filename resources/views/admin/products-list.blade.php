@forelse($products as $row)
<tr class="d-flex">
    <td class="col-5 media">
        <div class="d-flex">
            <input type="checkbox" class="form-check-input position-static align-self-center primary-checkbox"
                name="checked[]" id="checked{{ $row->id }}">
            <img class="ml-4" src="{{ asset('storage/products/' . $row->images->first()->filename) }}" width="100px"
                height="100px">
        </div>
        <div class="media-body">
            <p class="weight-600">{{ $row->name }}</p>
            <div class="rating"></div>
        </div>
    </td>
    <td class="col-3 media">
        <div class="media-body">
            <p><strong>Harga: </strong>
                @if( number_format($row->variant->first()->price) != number_format($row->variant->last()->price))
                Rp {{ number_format($row->variant->first()->price) }} - Rp
                {{ number_format($row->variant->last()->price) }}
                @else
                Rp {{ number_format($row->variant->first()->price) }}
                @endif
            </p>
        </div>
    </td>
    <td class="col-2 media">
        <div class="media-body">
            <p><strong>Stok: </strong>{{ $row->variant->sum('stock') }}</p>
        </div>
    </td>
    <td class="col-2 media">
        <div class="media-body">
            <a class="btn btn-outline-orange" href="{{ route('administrator.edit_product', $row->id) }}">Edit</a>
        </div>
    </td>
</tr>
@empty
@endforelse