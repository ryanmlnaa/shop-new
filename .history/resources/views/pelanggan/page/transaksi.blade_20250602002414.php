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
                    <form action="{{route('checkout')}} {{ route('cart.delete', $x->id) }}" method="POST">
                        @csrf
                        <div class="desc w-100"></div>
                        <div class="desc w-100">
                            <p style="font-size:24px; font-weight:700;">{{ $x->product->product_name }}</p>

                            <!-- Product ID -->
                            <input type="hidden" name="product_id" value="{{ $x->product->id }}">

                            <!-- Harga (readonly) -->
                            <input type="number" class="form-control border-0 fs-1" name="harga" readonly
                                id="harga"
                                value="{{ $x->product->price }}">

                            <!-- Quantity -->
                            <div class="row mb-2">
                                <label for="qty" class="col-sm-2 col-form-label fs-5">Quantity</label>
                                <div class="col-sm-5 d-flex">
                                    <button class="rounded-start bg-secondary p-2 border border-0 plus" type="button" id="plus">+</button>
                                    <input type="number" name="qty" class="form-control w-25 text-center qty"
                                        id="qty" value="{{ $x->qty }}">
                                    <button class="rounded-end bg-secondary p-2 border border-0 minus" type="button" id="minus" disabled>-</button>
                                </div>
                            </div>

                            <!-- Total (readonly) -->
                            <div class="row">
                                <label for="price" class="col-sm-2 col-form-label fs-5">Total</label>
                                <input type="text" class="col-sm-2 form-control w-25 border-0 fs-4 total" name="total"
                                    readonly id="total">
                            </div>

                            <!-- Tombol aksi -->
                            <div class="row w-50 gap-1">
                                <button type="submit" class="btn btn-success col-sm-5">
                                    <i class="fa fa-shopping-cart"></i>
                                    Checkout
                                </button>

                                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                        <i class="fa fa-trash-alt"></i> Delete
                                    </button>
                                 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif


@endsection
