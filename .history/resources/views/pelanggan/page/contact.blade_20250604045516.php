@extends('pelanggan.layout.index')

@section('content')
    <div class="row mt-4 align-items-center">
        <div class="col-md-6">
        <div class="content-text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat sequi, itaque perspiciatis vel nobis quisquam, culpa blanditiis magni libero vitae perferendis? Dolore vel neque id alias eos perspiciatis voluptate quisquam, ad cupiditate eveniet velit pariatur rerum aliquid expedita itaque, illo iusto quibusdam mollitia ullam porro! Maxime, porro iusto. Enim cupiditate ut nisi, dicta exercitationem aliquam amet, voluptatem impedit possimus neque explicabo repellendus laboriosam quisquam, maiores corporis eligendi tenetur pariatur architecto eius facere delectus sapiente numquam doloribus quia! Laboriosam distinctio tempore aut nihil iusto reiciendis voluptatibus ipsum! Quisquam iure nam eius deserunt. Officiis vero, nobis dolor excepturi perferendis iusto quae ut aperiam possimus odio, officia id in eum beatae qui natus architecto unde enim quibusdam, est aspernatur? Sint autem in expedita?
        </div>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('assets/images/office-img.png') }}" style="width:100%" alt="">
        </div>
    </div>

    <div class="d-flex justify-content-lg-between mt-5">
        <div class="d-flex align-items-center gap-4">
            <i class="fa fa-users fa-2x"> </i>
            <p class="m-0 fs-5">+ 300 Pelanggan</p>
        </div>
        <div class="d-flex align-items-center gap-4">
            <i class="fas fa-home fa-2x"> </i>
            <p class="m-0 fs-5">+ 500 Seller</p>
        </div>
        <div class="d-flex align-items-center gap-4">
            <i class="fas fa-shirt fa-2x"> </i>
            <p class="m-0 fs-5">+ 300 Product</p>
        </div>
    </div>

    <h4 class="text-center mt-md-5 mb-md-2">Contact Us</h4>
    <hr class="mb-5">
    <div class="row mb-md-5">
        {{-- <div class="col-md-5">
            <div  class="bg-secondary" style="width:100%; height: 50vh; border-radius:10px;"></div>
        </div> --}}
        <div class="col-md-7">
        <div class="card">
            <div class="card-header text-center">
                <h4>Kritik dan Saran</h4>
            </div>
            <div class="card-body">
                <p class="p-0 mb-5 text-lg-center">Masukkan kritik dan saran Anda kepada aplikasi kami ini agar kami dapat memberikan apa yang menjadi kebutuhan Anda dan kami dapat berkembang lebih baik lagi.</p>
            <div class="mb-3 row">
    <label for="email" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="email" value="" placeholder="Masukkan email Anda">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="pesan" class="col-sm-2 col-form-label">Pesan</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="pesan" placeholder="Masukkan pesan Anda">
    </div>
  </div>
  <button class="btn btn-primary mt-4 w-100">Kirim Pean Anda</button>
            </div>
        </div>
        </div>
    </div>
@endsection
