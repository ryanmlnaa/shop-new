<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Http;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function shop()
    {
         $data = Product::paginate(8);
    $countKeranjang = TblCart::where('idUser', 'guest123')
        ->where('status', 0)
        ->count();

    return view('pelanggan.page.shop', [
        'title' => 'Shop',
        'data' => $data,
        'count' => $countKeranjang,
    ]);
    public function index()
    {
        $data = Product::paginate(3);
        return view('admin.page.product', [
            'name'      => "Product",
            'title'     => 'Admin Product',
            'data'      => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addModal()
    {
        return view('admin/modal/addModal', [
            'title' => 'Tambah Data Product',
            'product_id'   => 'BRG' . rand(10000, 99999),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreproductRequest $request)
    {
        $data = new product;
        $data->product_id    = $request->product_id;
        $data->product_name  = $request->product_name;
        $data->product_brand = $request->product_brand;
        $data->gender        = $request->gender;
        $data->price         = $request->price;
        $data->description   = $request->description;
        $data->primary_color = $request->primary_color;
        $data->jenis_pakaian = $request->jenis_pakaian;
        $data->quantity      = $request->quantity;
        $data->discount      = 10 / 100;
        $data->is_active     = 1;

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/product'), $filename);
            $data->foto = $filename;
        }

        // dd($data);
        $data->save();
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('product');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Product::findOrFail($id);

        return view(
            'admin.modal.editModal',
            [
                'title' => 'Edit data product',
                'data'  => $data,
            ]
        )->render();
    }


    public function predictFromFlask(Request $request)
    {
        // dd($data);
        $response = Http::withHeaders([
            'x-api-key' => 'test-123',
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:5000/predict', [
            'JenisPakaian'  => $request->input('jenis_pakaian'),
            'ProductBrand'  => $request->input('product_brand'),
            'PrimaryColor'  => $request->input('primary_color'),
        ]);

        // dd($request);
        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Gagal prediksi'], 500);
        }
    }
      //  dd($data);

    public function update(UpdateproductRequest $request, product $product, $id)
    {
        $data = Product::findOrFail($id);


        if ($request->file('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/product'), $filename);
            $data->foto = $filename;
        } else {
            $filename = $request->foto;
        }

        $field = [
            'product_id'            => $request->product_id,
            'product_name'          => $request->product_name,
            'product_brand'         => $request->product_brand,
            'gender'                => $request->gender,
            'price'                 => $request->price,
            'description'           => $request->description,
            'primary_color'         => $request->primary_color,
            'jenis_pakaian'         => $request->jenis_pakaian,
            'quantity'              => $request->quantity,
            'discount'              => 10 / 100,
            'is_active'             => 1,
            'foto'                  => $filename,
        ];

        $data->update($field);
        Alert::toast('Data berhasil diupdate', 'success');
        return redirect()->route('product');
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        $json = [
            Alert::toast('Data berhasil dihapus', 'success')
        ];

        echo json_encode($json);
    }

    public function predictGender(Request $request)
    {
        $input = [
            'ProductBrand' => $request->input('merk'),
            'PrimaryColor' => $request->input('warna'),
        ];

        // Simpan input sementara jadi file JSON
        $inputPath = public_path('python/input.json');
        file_put_contents($inputPath, json_encode($input));

        // Panggil python script untuk prediksi
        $python = 'python'; // kalau di server Linux mungkin harus 'python3'
        $scriptPath = public_path('python/predict.py');

        $command = "$python $scriptPath";
        $output = shell_exec($command);

        return response()->json(['gender' => trim($output)]);
    }


}
