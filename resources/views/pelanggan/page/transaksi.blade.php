@extends('pelanggan.layout.index')

@section('content')
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .card-body {
            align-items: center;
        }

        .product-img {
            width: 150px;
            object-fit: cover;
        }

        .desc {
            flex: 1;
        }

        .qty-wrapper {
            max-width: 160px;
        }

        .qty-btn {
            width: 40px;
            font-weight: bold;
            color: #fff;
        }

        .qty-input {
            width: 60px;
            text-align: center;
        }

        .total-label {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .total-value {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .action-buttons {
            margin-top: 10px;
        }

        .btn-checkout {
            min-width: 130px;
        }

        .btn-delete {
            margin-left: 15px;
        }
    </style>

    <h3 class="mt-5 mb-4">Keranjang Belanja</h3>

    @if (!$data || $data->isEmpty())
        <div class="alert alert-info">Keranjang Anda kosong.</div>
    @else
        @foreach ($data as $x)
            <div class="card mb-4">
                <div class="card-body d-flex gap-4 flex-wrap">
                    <form action="{{ route('checkout') }}" method="POST" class="d-flex flex-wrap w-100 gap-4">
                        @csrf
                        <div class="desc w-100"></div>
                        <div class="desc w-100">
                            <p style="font-size:24px; font-weight:700;">{{ $x->product->product_name }}</p>

                            <input type="hidden" name="product_id" value="{{ $x->product_id }}">
                            <input type="number" class="form-control border-0 fs-3 mb-2" name="harga" readonly
                                id="harga" value="{{ $x->price }}">

                            <div class="mb-3">
                                <label for="qty" class="form-label">Quantity</label>
                                <div class="input-group qty-wrapper">
                                    <button class="btn btn-secondary qty-btn rounded-start plus" type="button"
                                        id="plus">+</button>
                                    <input type="number" name="qty" class="form-control qty-input qty" id="qty"
                                        value="{{ $x->qty ? $x->qty : 1 }}" min="1" max="100">
                                    <button class="btn btn-secondary qty-btn rounded-end minus" type="button" id="minus"
                                        disabled>-</button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="col-sm-2 col-form-label fs-5">Total</label>
                                <input type="text" class="col-sm-2 form-control w-25 border-0 fs-4 total" name="total" readonly
                                    id="total">
                            </div>

                            <div class="d-flex action-buttons ">
                                <button type="submit" class="btn btn-success btn-checkout">
                                    <i class="fa fa-shopping-cart me-1"></i> Checkout
                                </button>
                            </div>
                        </div>
                    </form>

                    <form action="{{ route('transaksi.destroy', ['id' => $x->id]) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus item ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
@endsection