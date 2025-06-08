@extends('admin.layout.index')

@section('content')
<div class="card rounded-full">
    <div class="card-header bg-transparent d-flex justify-content-between">
        <button class="btn btn-info" id="addData">
            <i class="fa fa-plus"></i> <span>Tambah User</span>
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
                    <td>
                        <img src="{{ asset('storage/user/' . $x->foto) }}" style="width:100px;">
                    </td>
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
            <div class="showData">
                Data ditampilkan {{ $data->count() }} dari {{ $data->total() }}
            </div>
            <div>
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Containers --}}
<div class="tampilData" style="display: none;"></div>
<div class="tampilEditData" style="display: none;"></div>
<div id="modalContainer"></div> {{-- <== INI PENTING UNTUK RENDER MODAL DARI AJAX --}}

{{-- Pastikan ini di akhir --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Tambah User
    $('#addData').click(function () {
        $.ajax({
            url: '{{ route('addModalUser') }}',
            success: function (response) {
                $('.tampilData').html(response).show();
                $('#userTambah').modal("show");
            }
        });
    });

    // Edit User
    $(document).on('click', '.editModal', function () {
        var userId = $(this).data('id');
        $.ajax({
            url: '/admin/user_management/editUser/' + userId,
            method: 'GET',
            success: function (response) {
                $('#modalContainer').html(response);
                $('#editUserModal').modal('show');
            },
            error: function (xhr) {
                alert('Gagal mengambil data user.');
                console.log(xhr.responseText);
            }
        });
    });

    // Delete User
    $(document).on('click', '.deleteData', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        Swal.fire({
            title: 'Hapus data?',
            text: "Kamu yakin untuk menghapus karyawan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('destroyDataUser', ['id' => ':id']) }}".replace(':id', id),
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.success, 'success');
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menghapus data', 'error');
                    }
                });
            }
        });
    });

    // CSRF token
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
</script>
@endsection
