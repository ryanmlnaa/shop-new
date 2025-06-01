@extends('pelanggan.layout.index')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5>Payment List</h5>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Id Transaksi</th>
                            <th>Nama Penerima</th>
                            <th>Total Transaksi</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle text-center">
                        @foreach ($data as $x => $item)
                            <tr>
                                <td>{{ ++$x }}</td>
                                <td>{{ $item->code_transaksi }}</td>
                                <td>{{ $item->nama_customer }}</td>
                                <td>{{ $item->total_harga }}</td>
                                <td>
                                    {{-- {{ dd($item->status) }} --}}

                                   @if ($item->status == 'paid')
                                   <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('keranjang.bayar', ['id' => $item->id]) }}"
                                        class="btn btn-success">Bayar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
