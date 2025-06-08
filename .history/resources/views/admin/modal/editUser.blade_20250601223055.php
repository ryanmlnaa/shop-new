@extends('admin.layout.index')

@section('content')
<div class="card rounded-full">
    <div class="card-header bg-transparent d-flex justify-content-between">
        <button class="btn btn-info" id="addData">
            <i class="fa fa-plus">
                <span>Tambah User</span>
            </i>
        </button>
        <input type="text" wire:model="search" class="form-control w-25" placeholder="Search....">
    </div>
    <div class="card-body">
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIK</th>
                    <th>Join Date</th>
                    <th>Nama Karyawan</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $y => $x)
                <tr class="align-middle">
                    <td>{{ ++$y }}</td>
                    <td><img src="{{ asset('storage/user/' . $x->foto) }}" style="width:100px;"></td>
                    <td>{{ $x->nik }}</td>
                    <td>{{ $x->created_at }}</td>
                    <td>{{ $x->name }}</td>
                    <td>
                        <span class='badge text-bg-{{ $x->role === 1 ? 'info' : 'success' }}'>
                            {{ $x->role === 1 ? 'Admin' : 'Manager' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge text-bg-{{ $x->is_active === 1 ? 'success' : 'danger' }}">
                            {{ $x->is_active === 1 ? 'Active' : 'No Active' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-info editModal" data-id="{{ $x->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger deleteData" data-id="{{ $x->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination d-flex flex-row justify-content-between">
            <div class="showData">Data ditampilkan {{ $data->count() }} dari {{ $data->total() }}</div>
            <div>{{ $data->links() }}</div>
        </div>
    </div>
</div>

{{-- Container modal --}}
<div class="tampilData" style="display: none;"></div>
<div class="tampilEditData" style="display: none;" id="modalContainer"></div>

{{-- Modal Tambah User --}}
<div class="modal fade" id="userTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addDataUser') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="nik" class="col-sm-5 col-form-label">NIK</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" id="nik" name="nik"
                                value="{{ $nik }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-5 col-form-label">Nama Karyawan</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="nama" autocomplete="off">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-5 col-form-label">Email Karyawan</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" id="email
