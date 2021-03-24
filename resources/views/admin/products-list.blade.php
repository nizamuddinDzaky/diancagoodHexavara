@forelse($products as $row)
<tr>
    <td class="media td-wrap px-3 font-14">
        <div class="d-inline-flex">
            <img class="mx-2 curved-border-2" src="{{ asset('storage/products/' . $row->images->first()->filename) }}" width="80px" height="80px">
            <p class="weight-600">{{ $row->name }}</p>
            <div class="rating"></div>
        </div>
    </td>
    <td class="td-wrap px-3 font-14">
        @if($row->variant->all() != NULL)
            @if( number_format($row->variant->first()->price) != number_format($row->variant->last()->price))
            Rp {{ number_format($row->variant->first()->price) }} - Rp
            {{ number_format($row->variant->last()->price) }}
            @else
            Rp {{ number_format($row->variant->first()->price) }}
            @endif
        @endif
    </td>
    <td class="td-wrap font-14">
        <p>{{ $row->variant->sum('stock') }}</p>
    </td>
    <td class="td-wrap font-14">
        <a class="btn btn-outline-orange" href="{{ route('administrator.edit_product', $row->id) }}">Edit</a>
    </td>
</tr>
@empty
@endforelse