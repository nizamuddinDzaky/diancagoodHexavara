<div class="table-responsive curved-border">
    <table class="table table-bordered text-gray-2">
        <thead>
            <tr class="d-flex">
                <th class="col-6">Nama Varian</th>
                <th class="col-3">Harga</th>
                <th class="col-3">Berat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($product_variants as $v)
            <tr class="d-flex">
                <td class="col-6">{{ $v->name }}</td>
                <td class="col-3">{{ $v->price }}</td>
                <td class="col-3">
                    <button type="button" class="btn btn-orange show-variant" onclick="showDetail({{ $v->id }})">Detail</button>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>