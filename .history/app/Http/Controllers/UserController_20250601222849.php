<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest; //
use App\Models\User; //
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert; //


class UserController extends Controller
{
    public function apiLogin(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Email tidak ditemukan'
        ], 404);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Password salah'
        ], 401);
    }

    if ($user->is_active === 0) {
        return response()->json([
            'success' => false,
            'message' => 'Akun belum aktif'
        ], 403);
    }

    return response()->json([
        'success' => true,
        'message' => 'Login berhasil',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]
    ]);
}
    public function index()
    {
        $data = User::paginate(10);
        return view('admin.page.user', [
            'name'  =>  "User Management",
            'title' => 'Admin user Management',
            'data'  => $data,
        ]);
    }

    public function addModalUser()
    {
        return view('admin.modal.modalUser', [
            'title' => 'Tambah Data User',
            'nik'   => date('Ymd').rand(000,999),
        ]);
    }
    public function store(UserRequest $request)
    {
        $data = new User;
        $data->nik          = $request->nik;
        $data->name         = $request->nama;
        $data->email        = $request->email;
        $data->password     = bcrypt($request->password);
        $data->alamat       = $request->alamat;
        $data->tlp          = $request->tlp;
        $data->role         = $request->role;
        $data->tglLahir     = $request->tglLahir;
        $data->is_active    = 1;
        $data->is_member    = 0;
        $data->is_admin     = 1;

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }
        $data->save();
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('userManagement');
    }
   public function show($id)
{
    $data = User::findOrFail($id);

    return view('admin.modal.editUser', [
        'title' => 'Edit data User',
        'data'  => $data,
    ])->render();
}

    public function update(UserRequest $request, $id)
    {
         $data = User::findOrFail($id);

         if ($request->file('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
         } else {
            $filename = $request->foto;
         }

         $field = [
            'nik'                   => $request->nik,
            'name'                  => $request->nama,
            'email'                 => $request->email,
            'password'              => bcrypt($request->password),
            'alamat'                => $request->alamat,
            'tlp'                   => $request->tlp,
            'tglLahir'              => $request->tglLahir,
            'role'                  => $request->role,
            'foto'                  => $filename,
         ];

         $data::where('id', $id)->update($field);
         Alert::toast('Data berhasil diupdate', 'success');
         return redirect()->route('userManagement');
    }
    public function destroy($id)
    {
        $product = User::findOrFail($id);
        $product->delete();

        $json = [
            'success' => "Data berhasil dihapus"
        ];

        echo json_encode($json);
    }

    public function storePelanggan(UserRequest $request)
    {
        $data = new User;
        $nik  = "Member" . rand(000, 999);
        $data->nik          = $nik;
        $data->name         = $request->name;
        $data->email        = $request->email;
        $data->password     = bcrypt($request->password);
        $data->alamat       = $request->alamat . " " . $request->alamat2;
        $data->tlp          = $request->tlp;
        $data->role         = 0;
        $data->tglLahir     = $request->date;
        $data->is_active    = 1;
        $data->is_member    = 1;
        $data->is_admin     = 0;

        // dd($request);die;

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }
        $data->save();
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('home');
    }

    public function loginProses(Request $request)
    {
        $dataLogin = [
            'email' => $request->email,
            'password'  => $request->password,
        ];

        $user = new User;
        $proses = $user::where('email', $request->email)->first();

        if ($proses->is_active === 0) {
            Alert::toast('Kamu belum register', 'error');
            return back();
        }
        if (Auth::attempt($dataLogin)) {
            Alert::toast('Kamu berhasil login', 'success');
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            Alert::toast('Email dan Password salah', 'error');
            return back();
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Kamu berhasil Logout', 'success');
        return redirect('/');
    }
}
