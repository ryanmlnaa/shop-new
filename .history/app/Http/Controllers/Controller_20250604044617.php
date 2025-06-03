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
use Illuminate\Support\Facades\DB;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
//
use RealRashid\SweetAlert\Facades\Alert;

use function Laravel\Prompts\progress;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function shop(Request $request)
    {
         if ($request->has('kategory') && $request->has('type')) {
            $category = $request->input('kategory');
            $type = $request->input('type');
            $data = product::where('kategory', $category)
                ->orWhere('type', $type)->paginate(5);
        } else {
             $data = Product::paginate(8);
        }
        $countKeranjang = TblCart::where('idUser', 'guest123')
        ->where('status', 0)
        ->count();

    return view('pelanggan.page.shop', [
        'title' => 'Shop',
        'data' => $data,
        'count' => $countKeranjang,
    ]);
    }


    public function transaksi()
    {
        $db = TblCart::with('product')->where('idUser', 'guest123')->get();
        $countKeranjang = TblCart::where('idUser', 'guest123')
        ->where('status', 0)
        ->count();

        return view('pelanggan.page.transaksi', [
            'title' => 'Transaksi',
            'count' => $countKeranjang,
            'data' => $db
        ]);
    }
    public function contact()
    {
       $countKeranjang = TblCart::where('idUser', 'guest123')
        ->where('status', 0)
        ->count();

    return view('pelanggan.page.contact', [
        'title' => 'Contact Us',
        'count' => $countKeranjang,
    ]);
    }

    public function checkout(Request $request)
    {
        // dd('Checkout page');
       // $data  = product::where('id', $id)->first();
        $productId = $request->input('product_id');
        $harga = $request->input('harga');
        $qty = $request->input('qty');
        $total = $request->input('total');

        $countKeranjang = tblCart::where(['idUser' => 'guest123', 'status' => 0])->count();
        $code = transaksi::count();
        $codeTransaksi = date('Ymd') . $code + 1;
        $detailBelanja = modelDetailTransaksi::where(['id_transaksi' => $codeTransaksi, 'status' => 0])
            ->sum('price');
        $jumlahBarang = modelDetailTransaksi::where(['id_transaksi' => $codeTransaksi, 'status' => 0])
            ->count('product_id');
        $qtyBarang = modelDetailTransaksi::where(['id_transaksi' => $codeTransaksi, 'status' => 0])
            ->sum('qty');
            // dd($productId);

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

         $code = transaksi::count();
         $codeTransaksi = date('Ymd') . ($code + 1);

        //  dd($codeTransaksi);
    // Kirim ke view checkout pembayaran
        return view('pelanggan.page.checkOut', compact(
            'product',
            'harga',
            'countKeranjang',
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
                'qty' => $data['totalQty'],
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

    public function keranjang()
    {
        $countKeranjang = tblCart::where(['idUser' => 'guest123', 'status' => 0])->count();
        $all_trx = transaksi::all();
        return view('pelanggan.page.keranjang', [
            'name' => 'Payment',
            'title' => 'Payment Process',
            'count' => $countKeranjang,
            'data'  => $all_trx
        ]);
    }

   public function bayar($id)
{
    $find_data = transaksi::find($id);
    $countKeranjang = tblCart::where(['idUser' => 'guest123', 'status' => 0])->count();

    // ✅ Buat order_id baru yang unik
    $order_id = 'INV-' . uniqid();

    // ✅ Simpan order_id ke kolom code_transaksi (jika perlu diingat)
    $find_data->code_transaksi = $order_id;
    $find_data->save();

    // ✅ Konfigurasi Midtrans
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    // ✅ Siapkan parameter transaksi
    $params = array(
        'transaction_details' => array(
            'order_id' => $order_id, // pakai yang unik
            'gross_amount' => $find_data->total_harga,
        ),
        'customer_details' => array(
            'first_name' => 'Mr',
            'last_name' => $find_data->nama_customer,
            'phone' => $find_data->no_tlp,
        ),
    );

    // ✅ Dapatkan token Snap
    $snapToken = \Midtrans\Snap::getSnapToken($params);

    return view('pelanggan.page.detailTransaksi', [
        'name' => 'Detail Transaksi',
        'title' => 'Detail Transaksi',
        'count' => $countKeranjang,
        'token' => $snapToken,
        'data' => $find_data,
    ]);
}

public function notificationHandler(Request $request)
{
    $data = json_decode($request->getContent(), true);
    Log::info('Callback masuk:', $data);

    $orderId = $data['order_id'] ?? null;
    $statusCode = $data['status_code'] ?? null;
    $grossAmount = $data['gross_amount'] ?? null;
    $signatureKey = $data['signature_key'] ?? null;
    $transactionStatus = $data['transaction_status'] ?? null;

    $serverKey = config('midtrans.server_key');

    $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

    if ($signature !== $signatureKey) {
        Log::warning('Signature tidak valid');
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    if (in_array($transactionStatus, ['capture', 'settlement'])) {
        $update = DB::table('transaksis')
            ->where('code_transaksi', $orderId)
            ->update(['status' => 'Paid']);

        Log::info("Update hasil: $update untuk order_id: $orderId");
    }

    return response()->json(['message' => 'Callback handled']);
}


    public function admin()
    {
        $dataProduct = product::count();
        $dataStock = product::sum('quantity');
        $dataTransaksi = transaksi::count();
        $dataPenghasilan = transaksi::sum('total_harga');
        return view('admin.page.dashboard', [
            'name' => "Dashboard",
            'title' => 'Admin Dashboard',
            'totalProduct'  => $dataProduct,
            'sumStock'      => $dataStock,
            'dataTransaksi' => $dataTransaksi,
            'dataPenghasilan' => $dataPenghasilan,
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

    public function transaksiDestroy(Transaksi $transaksi, $id)
    {
        // dd('Hapus transaksi dengan ID: ' . $id);
               $userId = 'guest123'; // atau pakai Auth::id() jika sudah login

    // Ambil cart item untuk user yang sedang aktif
    $items = TblCart::where([
        'idUser' => $userId,
        'status' => 0
    ])->with('product')->get();
    $cart = TblCart::find($id);
if ($cart) {
    $cart->delete();
} else {
    // Opsional: tampilkan alert atau log error
    Alert::error('Data tidak ditemukan', 'Gagal menghapus transaksi');
    return redirect()->back();
}
    $data = Product::all();

    return view('pelanggan.page.transaksi', [
        'title' => 'Transaksi',
        'items' => $items,
        'data' => $data,
    ]);
    }
}
