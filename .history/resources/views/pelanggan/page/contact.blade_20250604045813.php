@extends('pelanggan.layout.index')

@section('content')
    <div class="row mt-4 align-items-center">
        <div class="col-md-6">
        <div class="content-text">
           Aplikasi ini merupakan platform online shop berbasis web dan mobile yang dirancang untuk memberikan pengalaman berbelanja yang praktis dan modern. Dengan antarmuka yang responsif dan mudah digunakan, pengguna dapat mencari, memilih, dan membeli produk kapan saja dan di mana saja. Salah satu fitur unggulan dalam aplikasi ini adalah penerapan algoritma Naive Bayes melalui integrasi API cerdas untuk melakukan prediksi otomatis, seperti menentukan kategori gender produk berdasarkan nama, warna, dan merek. Fitur ini membantu admin dalam mempercepat proses input data produk dan meningkatkan konsistensi klasifikasi.
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
