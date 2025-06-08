<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\Http\Request;

class TransaksiAdminController extends Controller
{
    public function index()
    {
        $data = transaksi::paginate(10);
        return view('admin.page.transaksi', ['title' => "Transaksi", 'name' => 'Transaksi', 'data' => $data]);
    }

    public function transaksdestroy(Transaksi $transaksi)
    {
               $userId = 'guest123'; // atau pakai Auth::id() jika sudah login

    // Ambil cart item untuk user yang sedang aktif
    $items = TblCart::where([
        'idUser' => $userId,
        'status' => 0
    ])->with('product')->get();
    $data = Product::all();

    return view('pelanggan.page.transaksi', [
        'title' => 'Transaksi',
        'items' => $items,
        'data' => $data,
    ]);
    }
}
