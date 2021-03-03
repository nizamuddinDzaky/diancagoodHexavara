<div class="table-responsive curved-border">
    <table class="table table-bordered text-gray-2">
        <thead>
            <tr class="d-flex">
                <th class="col-3">Nama Varian</th>
                <th class="col-2">Harga</th>
                <th class="col-2">Berat</th>
                <th class="col-2">Stok</th>
                <th class="col-3">Gambar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($product_variants as $v)
            <tr class="d-flex">
                <td class="col-3">{{ $v->name }}</td>
                <td class="col-2">{{ $v->price }}</td>
                <td class="col-2">{{ $v->weight }}</td>
                <td class="col-2">{{ $v->stock }}</td>
                <td class="col-3">
                    <div class="d-flex">
                        <img class="mx-2" src="{{ asset('storage/variants/' . $v->image) }}" width="100px">
                    </div>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>