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
        <div class="alert alert-info">
            Keranjang Anda kosong.
        </div>
    @else
        @foreach ($data as $x)
            <div class="card mb-3">
                <div class="card-body d-flex gap-4">
                    <img src="{{ asset('storage/product/' . $x->product->foto) }}" width="300" alt="">

                    <div class="desc w-100">
                        <p style="font-size:24px; font-weight:700;">{{ $x->product->product_name }}</p>

                        <!-- Harga dan Qty -->
                        <div class="row mb-2">
                            <label class="col-sm-2 col-form-label fs-5">Harga</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control border-0 fs-5" value="{{ $x->product->price }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-sm-2 col-form-label fs-5">Quantity</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control border-0 fs-5" value="{{ $x->qty }}" readonly>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row gap-2 w-100 mt-3">
                            <!-- Form Checkout -->
                            <div class="col-sm-5 p-0">
                                <form action="{{ route('checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $x->product->id }}">
                                    <input type="hidden" name="qty" value="{{ $x->qty }}">
                                    <input type="hidden" name="harga" value="{{ $x->product->price }}">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fa fa-shopping-cart"></i> Checkout
                                    </button>
                                </form>
                            </div>

                            <!-- Form Delete -->
                            <div class="col-sm-5 p-0">
                                <form action="{{ route('cart.delete', $x->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fa fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
