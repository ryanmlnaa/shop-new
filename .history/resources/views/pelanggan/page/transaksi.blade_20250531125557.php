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
                    
                </div>
            </div>
        @endforeach
    @endif


@endsection
