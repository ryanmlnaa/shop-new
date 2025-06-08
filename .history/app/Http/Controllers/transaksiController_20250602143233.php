<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\modelDetailTransaksi;
use App\Http\Requestsus\StoretransaksiRequest;
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
        $userId = 'guest123';

        $best = Product::where('quantity_out','>=',5)->get();
        $data = Product::paginate(15);
        $countKeranjang = TblCart::where(['idUser' => 'guest123', 'status' => 0])->count();
        $item = TblCart::where([
        'idUser' => $userId,
        'status' => 0
    ])->with('product')->get();

        return view('pelanggan.page.home', [
            'title'     => 'Home',
            'data'      => $data,
            'best'      => $best,
            'count'     => $countKeranjang,
            'item' => $item,
        ]);
    }
public function transaksi()
{
    $userId = 'guest123'; // atau pakai Auth::id() jika sudah login

    // Ambil cart item untuk user yang sedang aktif
    $items = TblCart::where([
        'idUser' => $userId,
        'status' => 0
    ])->with('product')->get();
    

    return view('pelanggan.page.transaksi', [
        'title' => 'Transaksi',
        'items' => $items
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




   public function store(Request $request)
{

    $validated = $request->validate([
        'total_qty' => 'required|integer',
        'total_harga' => 'required|integer',
        'nama_customer' => 'required|string',
        'alamat' => 'required|string',
        'no_tlp' => 'required|string',
        'ekspedisi' => 'required|string',
        'details' => 'required|array|min:1',
        'details.*.product_id' => 'required|integer',
        'details.*.qty' => 'required|integer',
        'details.*.price' => 'required|integer',
    ]);

    DB::beginTransaction();

    try {
        $transaksi = Transaksi::create([
            'code_transaksi' => now()->format('YmdHis') . rand(100, 999),
            'total_qty' => $validated['total_qty'],
            'total_harga' => $validated['total_harga'],
            'nama_customer' => $validated['nama_customer'],
            'alamat' => $validated['alamat'],
            'no_tlp' => $validated['no_tlp'],
            'ekspedisi' => $validated['ekspedisi'],
        ]);

        foreach ($validated['details'] as $item) {
            modelDetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat',
            'data' => $transaksi->load('detailTransaksi'),
        ]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function deleteCart($id)
{
    $cartItem = TblCart::where('id', $id)->where('idUser', 'guest123')->where('status', 0)->first();

    if ($cartItem) {
        $cartItem->delete();
        Alert::success('Berhasil', 'Item berhasil dihapus dari keranjang.');
    } else {
        Alert::error('Gagal', 'Item tidak ditemukan.');
    }

    return redirect()->back();
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
        //
    }


}
