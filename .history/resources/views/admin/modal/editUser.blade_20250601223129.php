<div class="modal fade" id="{{ isset($data) ? 'editModal' : 'userTambah' }}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ isset($data) ? route('updateDataUSer', $data->id) : route('addDataUser') }}"
                enctype="multipart/form-data" method="POST">
                @csrf
                @if(isset($data))
                    @method('PUT')
                @endif

                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="nik" class="col-sm-5 col-form-label">NIK</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" id="nik" name="nik"
                                value="{{ isset($data) ? $data->nik : $nik }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="col-sm-5 col-form-label">Nama Karyawan</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="nama" autocomplete="off"
                                value="{{ old('nama', isset($data) ? $data->name : '') }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-5 col-form-label">Email Karyawan</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" id="email" name="email"
                                autocomplete="off"
                                value="{{ old('email', isset($data) ? $data->email : '') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-sm-5 col-form-label">Password Karyawan</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="password" name="password"
                                autocomplete="off" value="">
                            @if(isset($data))
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-5 col-form-label">Alamat Karyawan</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="{{ old('alamat', isset($data) ? $data->alamat : '') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="tlp" class="col-sm-5 col-form-label">Telphone Karyawan</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="tlp" name="tlp"
                                value="{{ old('tlp', isset($data) ? $data->tlp : '') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="tglLahir" class="col-sm-5 col-form-label">Tanggal lahir</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" id="tglLahir" name="tglLahir"
                                value="{{ old('tglLahir', isset($data) ? $data->tglLahir : '') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="role" class="col-sm-5 col-form-label">Jabatan</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="role" name="role">
                                <option value="">Pilih Role</option>
                                <option value="1" {{ old('role', isset($data) ? $data->role : '') == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ old('role', isset($data) ? $data->role : '') == 2 ? 'selected' : '' }}>Manager</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-5 col-form-label">Foto Profil</label>
                        <div class="col-sm-7">
                            <input type="hidden" name="foto">
                            <img class="mb-2 preview" style="width: 100px;"
                                src="{{ isset($data) ? asset('storage/user/'.$data->foto) : '' }}">
                            <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="inputFoto"
                                name="foto" onchange="previewImg()">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImg() {
        const fotoIn = document.querySelector('#inputFoto');
        const preview = document.querySelector('.preview');

        preview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(fotoIn.files[0]);

        oFReader.onload = function(oFREvent) {
            preview.src = oFREvent.target.result;
        }
    }
</script>
