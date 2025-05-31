<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addData') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="product_id" class="col-sm-5 col-form-label">Kode Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" id="product_id" name="product_id"
                                value="{{ $product_id ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="product_name" class="col-sm-5 col-form-label">Nama Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="product_brand" class="col-sm-5 col-form-label">Merk Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="product_brand" name="product_brand">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-sm-5 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="gender" name="gender">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="price" class="col-sm-5 col-form-label">Harga</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="price" name="price">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-sm-5 col-form-label">Deskripsi</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="primary_color" class="col-sm-5 col-form-label">Warna</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="primary_color" name="primary_color"> <!-- sebelumnya name="warna" -->
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenis_pakaian" class="col-sm-5 col-form-label">Jenis Pakaian</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="jenis_pakaian" name="jenis_pakaian"> <!-- sebelumnya name="warna" -->
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="quantity" class="col-sm-5 col-form-label">Qty Product</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="quantity" name="quantity">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-5 col-form-label">Foto Product</label>
                        <div class="col-sm-7">
                            <input type="hidden" name="foto">
                            <img class="mb-2 preview"
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
     function fetchPredictionIfComplete() {
        const name = $('#jenis_pakaian').val();
        const brand = $('#product_brand').val();
        const color = $('#primary_color').val();

        if (name && brand && color) {
            $.ajax({
                url: '/predict-flask',
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify({
                    jenis_pakaian: name,
                    product_brand: brand,
                    primary_color: color
                }),
                // dd($request)
                success: function(response) {
                    console.log(response);
                    // $('#product_name').val(response.ProductName);
                    $('#gender').val(response.Gender);
                    $('#price').val(response.Price_INR);
                    $('#description').val(response.Description);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    }

    $(document).ready(function(){
        $('#jenis_pakaian, #product_brand, #primary_color').on('change', fetchPredictionIfComplete);
    });

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

    $(document).ready(function(){
    $('#merk-product, #warna').on('change', function() {
        var merk = $('#merk-product').val();
        var warna = $('#warna').val();

        if (merk && warna) {
            $.ajax({
                url: '/predict-Gender',
                method: 'POST',
                data: {
                    merk: merk,
                    warna: warna,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    $('#jenis-kelamin').val(response.gender); // isi otomatis
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
