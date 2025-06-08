@extends('pelanggan.layout.index')

@section('content')
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .qty-group button {
            width: 40px;
        }
        .qty-group input {
            width: 60px;
        }
    </style>

    <h3 class="mt-5 mb-4">Keranjang Belanja</h3>

    @if (!$data || $data->isEmpty())
        <div class="alert alert-info">Keranjang Anda kosong.</div>
    @else
        @foreach ($data as $x)
            <div class="card mb-4">
                <div class="card-body row align-items-center">

                    {{-- Gambar Produk --}}
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('storage/product/' . $x->foto) }}" class="img-fluid" alt="Gambar Produk">
                    </div>

                    {{-- Detail Produk --}}
                    <div class="col-md-6">
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <h5 class="fw-bold">{{ $x->product_name }}</h5>

                            <input type="hidden" name="product_id" value="{{ $x->product_id }}">

                            {{-- Harga --}}
                            <div class="mb-2">
                                <span class="fw-bold fs-4">Rp {{ number_format($x->price, 0, ',', '.') }}</span>
                                <input type="hidden" name="harga" value="{{ $x->price }}">
                            </div>

                            {{-- Quantity --}}
                            <div class="mb-3 d-flex align-items-center">
                                <label class="me-2">Quantity:</label>
                                <div class="qty-group d-flex align-items-center">
                                    <button type="button" class="btn btn-secondary minus" id="minus">-</button>
                                    <input type="number" name="qty" class="form-control text-center mx-1 qty" value="{{ $x->qty ?? 1 }}" min="1" max="100">
                                    <button type="button" class="btn btn-secondary plus" id="plus">+</button>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="mb-3">
                                <label>Total:</label>
                                <input type="text" class="form-control border-0 fs-5 total w-auto" name="total" readonly id="total">
                            </div>

                            {{-- Tombol Checkout --}}
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-shopping-cart me-1"></i> Checkout
                            </button>
                        </form>
                    </div>

                    {{-- Tombol Delete --}}
                    <div class="col-md-3 text-end">
                        <form action="{{ route('transaksi.destroy', ['id' => $x->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus item ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@section('scripts')
<script>
    document.querySelectorAll('.card').forEach(function(card) {
        const qtyInput = card.querySelector('.qty');
        const priceInput = card.querySelector('input[name="harga"]');
        const totalInput = card.querySelector('.total');
        const plusBtn = card.querySelector('.plus');
        const minusBtn = card.querySelector('.minus');

        function updateTotal() {
            const qty = parseInt(qtyInput.value);
            const harga = parseInt(priceInput.value);
            totalInput.value = (qty * harga).toLocaleString();
        }

        plusBtn.addEventListener('click', function() {
            qtyInput.value = parseInt(qtyInput.value) + 1;
            updateTotal();
        });

        minusBtn.addEventListener('click', function() {
            if (parseInt(qtyInput.value) > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
                updateTotal();
            }
        });

        qtyInput.addEventListener('input', updateTotal);

        updateTotal(); // init
    });
</script>
@endsection
