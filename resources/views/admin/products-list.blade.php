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
            <p><strong>Harga: </strong>Rp {{ number_format($row->price, 2, ',', '.') }}</p>
        </div>
    </td>
    <td class="col-2 media">
        <div class="media-body">
            <p><strong>Stok: </strong>{{ $row->variant->sum('stock') }}</p>
        </div>
    </td>
    <td class="col-2 media">
        <div class="media-body">
            <button class="btn btn-outline-orange">Edit</button>
        </div>
    </td>
</tr>
@empty
@endforelse