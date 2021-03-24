<div class="table-responsive curved-border">
    <table class="table table-bordered text-gray-2">
        <thead>
            <tr>
                <th class="td-wrap px-3">Nama Varian</th>
                <th class="td-wrap px-3">Harga</th>
                <th class="td-wrap px-3">Berat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($product_variants as $v)
            <tr id="rowvar{{ $v->id }}">
                <td class="td-wrap px-3" id="rowvar{{ $v->id }}name">{{ $v->name }}</td>
                <td class="td-wrap px-3" id="rowvar{{ $v->id }}price">Rp {{ number_format($v->price, 2, ',', '.') }}</td>
                <td class="td-wrap px-3">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-orange-2 show-variant" onclick="showDetail({{ $v->id }})">Detail</button>
                        <button type="button" class="btn btn-outline-orange-2 edit-variant" onclick="editVariant({{ $v->id }})">Edit</button>
                        <button type="button" class="btn btn-outline-orange-2 delete-variant" onclick="deleteVariant({{ $v->id }})">Hapus</button>
                    </div>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>