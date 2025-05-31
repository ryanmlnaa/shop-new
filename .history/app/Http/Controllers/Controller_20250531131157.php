<?php

namespace App\Http\Controllers;

use App\Models\modelDetailTransaksi;
use App\Models\TblCart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\transaksi;
//
use RealRashid\SweetAlert\Facades\Alert;

use function Laravel\Prompts\progress;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function shop()
    {
        $data = Product::paginate(8);
        $countKeranjang = TblCart::count();
        return view('pelanggan.page.shop', [
            'title' => 'Shop',
            'data' => $data,
            'count' => $countKeranjang,
        ]);
    }
    public function transaksi()
    {
        $db = TblCart::with('product')->where('idUser', 'guest123')->get();
        $countKeranjang = TblCart::count();

        // dd($db->product->product_name);
        return view('pelanggan.page.transaksi', [
            'title' => 'Transaksi',
            'count' => $countKeranjang,
            'data' => $db
        ]);
    }
    public function contact()
    {
        $countKeranjang = TblCart::count();
        return view('pelanggan.page.contact', [
            'title' => 'Contact Us',
            'count' => $countKeranjang,

        ]);
    }

    public function checkout(Request $request)
    {
       // $data  = product::where('id', $id)->first();
        $productId = $request->input('product_id');
    $harga = $request->input('harga');
    $qty = $request->input('qty');
    $total = $request->input('total');

    $countKeranjang = tblCart::where(['idUser' => 'guest123', 'status' => 0])->count();

    // Ambil data produk dari DB (jaga-jaga jika ingin informasi lebih detail)
    $product = Product::find($productId);

    // Validasi sederhana
    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan');
    }

    // Hitung total belanja dan info lainnya
    $jumlahbarang = 1; // Jika hanya satu jenis produk
    $qtyOrder = $qty;
    $detailBelanja = $total;

    // Buat kode transaksi unik (bisa disesuaikan)
    $codeTransaksi = 'TRX-' . strtoupper(uniqid());

    // Kirim ke view checkout pembayaran
    return view('pelanggan.page.checkOut', compact(
        'product',
        'harga',
        ''count' => $countKeranjang,'
        'qty',
        'total',
        'detailBelanja',
        'jumlahbarang',
        'qtyOrder',
        'codeTransaksi'
    ));
    // Hitung jumlah item di keranjang
    // $countKeranjang = tblCart::where(['idUser' => 'guest123', 'status' => 0])->count();

    // // Ambil transaksi aktif (status 0)
    // $transaksiAktif = modelDetailTransaksi::where('status', 0)
    //     ->orderBy('created_at', 'desc')
    //     ->first();

    // if ($transaksiAktif) {
    //     $codeTransaksi = $transaksiAktif->id_transaksi;
    // } else {
    //     $code = transaksi::count();
    //     $codeTransaksi = date('Ymd') . ($code + 1);
    // }

    // // Hitung total belanja
    // $detailBelanja = modelDetailTransaksi::where([
    //     'id_transaksi' => $codeTransaksi,
    //     'status' => 0
    // ])->get()->sum(function ($item) {
    //     return $item->qty * $item->price;
    // });

    // $jumlahBarang = modelDetailTransaksi::where([
    //     'id_transaksi' => $codeTransaksi,
    //     'status' => 0
    // ])->count('product_id');

    // $qtyBarang = modelDetailTransaksi::where([
    //     'id_transaksi' => $codeTransaksi,
    //     'status' => 0
    // ])->sum('qty');



    }
    public function prosesCheckout(Request $request, $id)
    {
        $data   = $request->all();
        // $findId = TblCart::where('id',$id)->get();
      $transaksiAktif = modelDetailTransaksi::where('status', 0)
    ->orderBy('created_at', 'desc')
    ->first();

    if ($transaksiAktif) {
        $codeTransaksi = $transaksiAktif->id_transaksi;
    } else {
        $code = transaksi::count() + 1;
        $codeTransaksi = date('Ymd') . $code;
    }

        // simpan detail barang
        $detailTransaksi = new modelDetailTransaksi();

        $fieldDetail = [
            'id_transaksi' => $codeTransaksi,
            'product_id' => $data['product_id'],
            'qty' => $data['qty'],
            'price' => $data['total']
        ];
        $detailTransaksi::create($fieldDetail);

        // update cart
        $fieldCart = [
            'qty' => $data['qty'],
            'price' => $data['total'],
            'status'       => 1,
        ];
        tblCart::where('id', $id)->update($fieldCart);

        Alert::success('Checkout Berhasil', 'Success');
       return redirect()->route('checkout');
    }

     public function prosesPembayaran(Request $request)
    {
        $data = $request->all();
        $dbTransaksi = new transaksi();
        // dd($data);die;

        $dbTransaksi->code_transaksi    = $data['code'];
        $dbTransaksi->total_qty         = $data['totalQty'];
        $dbTransaksi->total_harga       = $data['dibayarkan'];
        $dbTransaksi->nama_customer     = $data['namaPenerima'];
        $dbTransaksi->alamat            = $data['alamatPenerima'];
        $dbTransaksi->no_tlp            = $data['tlp'];
        $dbTransaksi->ekspedisi         = $data['ekspedisi'];

        $dbTransaksi->save();

        $dataCart = modelDetailTransaksi::where('id_transaksi', $data['code'])->get();
        foreach ($dataCart as $x) {
            $dataUp = modelDetailTransaksi::where('id', $x->id)->first();
            $dataUp->status    = 1;
            $dataUp->save();

            $idProduct = product::where('id', $x->id_barang)->first();
            $idProduct->quantity = $idProduct->quantity - $x->qty;
            $idProduct->quantity_out = $x->qty;
            $idProduct->save();

        }

        Alert::alert()->success('Transaksi berhasil', 'Ditunggu barangnya');
        return redirect()->route('home');
    }

    public function admin()
    {
        return view('admin.page.dashboard', [
            'name' => "Dashboard",
            'title' => 'Admin Dashboard',
        ]);
    }
    public function userManagement()
    {
        return view('admin.page.user', [
            'name' => "User Management",
            'title' => 'Admin user Management',
        ]);
    }
    public function report()
    {
        return view('admin.page.report', [
            'name' => "Report",
            'title' => 'Admin Report',
        ]);
    }
    public function login()
    {
        return view('admin.page.login', [
            'name' => "Login",
            'title' => 'Admin Login',
        ]);
    }
    public function loginProses(HttpRequest $request)
    {
        Session::flash('error', $request->email);
        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = new User;
        $proses = $user::where('email', $request->email)->first();

        if ($proses->is_admin === 0) {
            Session::flash('error', 'Kamu bukan admin');
            return back();
        } else {
            if (Auth::attempt($dataLogin)) {
                Alert::toast('Kamu berhasil login', 'success');
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            } else {
                Alert::toast('Email dan Password salah', 'error');
                return back();
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Kamu berhasil Logout', 'success');
        return redirect('admin');
    }
}
