<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoretransaksiRequest;
use App\Http\Requests\UpdatetransaksiRequest;
use App\Models\Product;
use App\Models\TblCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $best = Product::where('quantity_out','>=',5)->get();
        $data = Product::paginate(15);
        $countKeranjang = TblCart::where(['idUser' => 'guest123', 'status' => 0])->count();
        return view('pelanggan.page.home', [
            'title'     => 'Home',
            'data'      => $data,
            'best'      => $best,
            'count'     => $countKeranjang,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
   public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product_id = $request->input('product_id');
        $product = Product::find($product_id);
        $idUser = 'guest123';

        // Cek apakah produk sudah ada di keranjang
        $existingCart = TblCart::where('idUser', $idUser)
            ->where('product_id', $product_id)
            ->where('status', 0) // Belum checkout
            ->first();

        if ($existingCart) {
            $newQty = $existingCart->qty + 1;
            $existingCart->update([
                'qty' => $newQty,
                'price' => $newQty * $product->price,
                'updated_at' => now()
            ]);
        } else {
            TblCart::create([
                'idUser' => $idUser,
                'product_id' => $product_id,
                'status' => 0,
                'qty' => 1,
                'price' => $product->price,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Alert::success('Sukses', 'Produk berhasil ditambahkan ke keranjang!');
        return redirect('/shop');
    }

//




    public function store(StoreTransaksiRequest $request)
    {
    //      $kode = '20250531' . rand(100,999); // atau sesuai logikamu
    // $nama = $request->input('nama_customer');
    // $total = $request->input('total_harga');

    // Transaksi::create([
    //     'code_transaksi' => $kode,
    //     'nama_customer' => $nama,
    //     'total_harga' => $total,
    //     'status' => Transaksi::STATUS_UNPAID, // gunakan konstanta biar rapi
    //     // isian lain jika ada...
    // ]);

    // return redirect()->back()->with('success', 'Transaksi berhasil dibuat!');
    }


    public function show(Transaksi $transaksi)
    {

    }


    public function edit(Transaksi $transaksi)
    {
        //
    }

    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }


    public function destroy(Transaksi $transaksi)
    {
        
    }


}
