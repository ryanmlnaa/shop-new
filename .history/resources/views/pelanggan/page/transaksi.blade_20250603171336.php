@extends('pelanggan.layout.index')

@section('content')
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <h3 class="mt-5 mb-5">Keranjang Belanja</h3>

    @if (!$data || $data->isEmpty())
        <div class="alert alert-info">Keranjang Anda kosong.</div>
    @else
        @foreach ($data as $x)
            <div class="card mb-4 shadow-sm">
                <div class="card-body d-flex flex-wrap gap-4">
                    <form action="{{ route('checkout') }}" method="POST" class="flex-grow-1">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('storage/product/' . $x->foto) }}" width="200" class="img-fluid" alt="Foto Produk">
                            </div>
                            <div class="col-md-8">
                                <p class="fs-3 fw-bold mb-2">{{ $x->product_name }}</p>

                                <!-- Product ID -->
                                <input type="hidden" name="product_id" value="{{ $x->product_id }}">

                                <!-- Harga (readonly) -->
                                <input type="number" class="form-control border-0 fs-4 mb-2 harga" name="harga" readonly value="{{ $x->price }}">

                                <!-- Quantity -->
                                <div class="mb-3">
                                    <label class="form-label fs-5">Quantity</label>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-secondary minus">-</button>
                                        <input type="number" name="qty" class="form-control qty text-center mx-2" value="{{ $x->qty ?? 1 }}" min="1" max="100" style="width:80px;">
                                        <button type="button" class="btn btn-secondary plus">+</button>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="mb-3">
                                    <label class="form-label fs-5">Total</label>
                                    <input type="text" class="form-control total fs-4" name="total" readonly>
                                </div>

                                <!-- Checkout Button -->
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-shopping-cart"></i> Checkout
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Delete Button -->
                    <form action="{{ route('transaksi.destroy', ['id' => $x->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus item ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-auto">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.card').forEach(function (card) {
        const qtyInput = card.querySelector('.qty');
        const priceInput = card.querySelector('.harga');
        const totalInput = card.querySelector('.total');
        const plusBtn = card.querySelector('.plus');
        const minusBtn = card.querySelector('.minus');

        function updateTotal() {
            const qty = parseInt(qtyInput.value) || 0;
            const harga = parseInt(priceInput.value) || 0;
            const total = qty * harga;
            totalInput.value = isNaN(total) ? 0 : total;
        }

        plusBtn.addEventListener('click', function () {
            let qty = parseInt(qtyInput.value) || 1;
            qtyInput.value = qty + 1;
            updateTotal();
        });

        minusBtn.addEventListener('click', function () {
            let qty = parseInt(qtyInput.value) || 1;
            if (qty > 1) {
                qtyInput.value = qty - 1;
                updateTotal();
            }
        });

        qtyInput.addEventListener('input', updateTotal);

        // Hitung total saat pertama kali ditampilkan
        updateTotal();
    });
</script>
@endsection
