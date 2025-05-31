<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('updateData', $data->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="SKU" class="col-sm-5 col-form-label">Kode Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" id="product_id" name="product_id"
                                value="{{ $data->product_id }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="product_name" class="col-sm-5 col-form-label">Nama Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                value="{{ $data->product_name }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="product_brand" class="col-sm-5 col-form-label">Merk Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="product_brand" name="product_brand"
                                value="{{ $data->product_brand }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-sm-5 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="gender" name="gender"
                                value="{{ $data->gender }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-5 col-form-label">Harga</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="price" name="price"
                                value="{{ $data->price }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-sm-5 col-form-label">Deskripsi</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="description" name="description"
                                value="{{ $data->description }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="primary_color" class="col-sm-5 col-form-label">Warna</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="primary_color" name="primary_color"
                                value="{{ $data->primary_color }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenis_pakaian" class="col-sm-5 col-form-label">Jenis Pakaian</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="jenis_pakaian" name="jenis_pakaian"
                                value="{{ $data->jenis_pakaian }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="quantity" class="col-sm-5 col-form-label">Qty Product</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ $data->quantity }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-5 col-form-label">Foto Product</label>
                        <div class="col-sm-7">
                            <input type="hidden" name="foto" value="{{$data->foto}}">
                            <img src="{{ asset('storage/product/' . $data->foto) }}" class="mb-2 preview"
                                style="width: 100px;">
                            <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="inputFoto"
                                name="foto" onchange="previewImg()">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImg() {
        const fotoIn = document.querySelector('#inputFoto');
        const preview = document.querySelector('.preview');

        preview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(fotoIn.files[0]);

        oFReader.onload = function(oFREvent) {
            preview.src = oFREvent.target.result;
        }
}
</script>
