@extends('pelanggan.layout.index')

@section('content')
<div class="row mt-4 text-center">
    {{-- Sidebar Kategori --}}
    {{-- <div class="col-md-3">
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Category
            </div>
           <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Pria
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="d-flex flex-column gap-4">
                                        <div class="d-flex flex-row gap-3">
                                            <input type="checkbox" name="kategory" class="kategory" value="celana Pria">
                                            <span>Celana Pria</span>
                                        </div>
                                        <div class="d-flex flex-row gap-3">
                                            <input type="checkbox" name="kategory" class="kategory" value="baju Pria">
                                            <span>Baju Pria</span>
                                        </div>
                                        <div class="d-flex flex-row gap-3">
                                            <input type="checkbox" name="kategory" class="kategory" value="aksesoris Pria">
                                            <span>Aksesoris Pria</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Wanita
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0">
                                    <div class="accordion-body">
                                        <div class="d-flex flex-column gap-4">
                                            <div class="d-flex flex-row gap-3">
                                                <input type="checkbox" name="kategory" class="kategory"
                                                    value="celana Wanita">
                                                <span>Celana Wanita</span>
                                            </div>
                                            <div class="d-flex flex-row gap-3">
                                                <input type="checkbox" name="kategory" class="kategory" value="baju Wanita">
                                                <span>Baju Wanita</span>
                                            </div>
                                            <div class="d-flex flex-row gap-3">
                                                <input type="checkbox" name="kategory" class="kategory"
                                                    value="aksesoris Wanita">
                                                <span>Aksesoris Wanita</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    Anak-anak
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="accordion-body p-0">
                                        <div class="d-flex flex-column gap-4">
                                            <div class="d-flex flex-row gap-3">
                                                <input type="checkbox" name="kategory" class="kategory"
                                                    value="celana anak-anak">
                                                <span>Celana Anak-anak</span>
                                            </div>
                                            <div class="d-flex flex-row gap-3">
                                                <input type="checkbox" name="kategory" class="kategory"
                                                    value="baju anak-anak">
                                                <span>Baju Anak-anak</span>
                                            </div>
                                            <div class="d-flex flex-row gap-3">
                                                <input type="checkbox" name="kategory" class="kategory"
                                                    value="aksesoris anak-anak">
                                                <span>Aksesoris Anak-anak</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div> --}}

    {{-- Produk --}}
    <div class="col-md-9 d-flex flex-wrap gap-4 mb-5">
        @if ($data->isEmpty())
            <h1>Belum ada produk ...!</h1>
        @else
            @foreach ($data as $p)
                <div class="card" style="width:220px;">
                    <div class="card-header m-auto" style="height:100%;width:100%;">
                        <img src="{{ asset('storage/product/' . $p->foto) }}" alt="{{ $p->product_name }}"
                            style="width: 100%; height:200px; object-fit: cover;">
                    </div>
                    <div class="card-body">
                        <p class="m-0 text-justify">{{ $p->product_name }}</p>
                        <p class="m-0"><i class="fa-regular fa-star"></i> 5+</p>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                        <p class="m-0" style="font-size: 16px; font-weight: 600;"><span>IDR
                            </span> {{ number_format($p->price) }}</p>

                        {{-- FORM ADD TO CART --}}
                        <form action="{{ route('addToCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $p->id }}"> {{-- --}}

                            <button type="submit" class="btn btn-outline-primary" style="font-size:24px">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Pagination --}}
    @if (!$data->isEmpty())

    <div class="pagination d-flex flex-row justify-content-between">
        <div class="showData">
            Data ditampilkan {{ $data->count() }} dari {{ $data->total() }}
        </div>
        <div>
            {{ $data->links() }}
        </div>
    </div>
    @endif

    <script>
        $(document).ready(function() {
            $('.kategory').change(function(e) {
                e.preventDefault();
                var value = $(this).val();
                var split = value.split(' ');
                var kategory = split[0];
                var type = split[1];
                // alert(type);
                $.ajax({
                    type: "GET",
                    url: "{{ route('shop') }}",
                    data: {
                        kategory: kategory,
                        type: type,
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
</div>
@endsection
