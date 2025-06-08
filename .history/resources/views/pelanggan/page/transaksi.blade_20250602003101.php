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

                        <!-- Harga -->
                        <input type="number" class="form-control border-0 fs-1 mb-2" name="harga" readonly
                            value="{{ $x->product->price }}">

                        <!-- Quantity -->
                        <div class="row mb-2">
                            <label for="qty" class="col-sm-2 col-form-label fs-5">Quantity</label>
                            <div class="col-sm-5 d-flex">
                                <button class="rounded-start bg-secondary p-2 border border-0 plus" type="button">+</button>
                                <input type="number" name="qty" class="form-control w-25 text-center qty"
                                    value="{{ $x->qty }}">
                                <button class="rounded-end bg-secondary p-2 border border-0 minus" type="button" disabled>-</button>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fs-5">Total</label>
                            <input type="text" class="col-sm-2 form-control w-25 border-0 fs-4 total"
                                name="total" readonly>
                        </div>

                        <!-- Tombol aksi -->
                        <div class="row w-50 gap-1">
                            {{-- Form Checkout --}}
                            <div class="col-sm-5 p-0">
                                <form action="{{ route('checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $x->product->id }}">
                                    <input type="hidden" name="harga" value="{{ $x->product->price }}">
                                    <input type="hidden" name="qty" value="{{ $x->qty }}">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fa fa-shopping-cart"></i> Checkout
                                    </button>
                                </form>
                            </div>

                            {{-- Form Delete --}}
                            <div class="col-sm-5 p-0">
                                <form action="{{ route('cart.delete', $x->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
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
