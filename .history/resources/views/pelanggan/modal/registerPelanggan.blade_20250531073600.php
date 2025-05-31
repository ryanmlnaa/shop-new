<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-md ">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="registerModalLabel">Register</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3 row">
    <label for="nama" class="col-sm-3 col-form-label">Name <span style="color:red;">*</span></label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="nama" id="nama" value="" placeholder="Your Name" required>
    </div>
  </div>
      <div class="mb-3 row">
    <label for="email" class="col-sm-3 col-form-label">Email <span style="color:red;">*</span></label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="email" id="email" value="" placeholder="Your email"
      required>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="Password" class="col-sm-3 col-form-label">Password <span style="color:red;">*</span></label>
    <div class="col-sm-9">
      <input type="password" class="form-control" name= "Password" id="password" placeholder="Your Password">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="alamat" class="col-sm-3 col-form-label">Addres 1 <span style="color:red;">*</span></label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Input Addres 1">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="alamat" class="col-sm-3 col-form-label">Addres 2 </label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="alamat2" id="alamat" placeholder="Input Addres 2">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="tlp" class="col-sm-3 col-form-label">Phone Number <span style="color:red;">*</span></label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="tlp" id="tlp"  placeholder="Input Phone Number">
    </div>
  </div>
  <div class="mb-5 row">
    <label for="date" class="col-sm-3 col-form-label">Date of birth <span style="color:red;">*</span></label>
    <div class="col-sm-9">
      <input type="date" class="form-control" name="date" id="date"  placeholder="Input Phone Number">
    </div>
  </div>
        <button type="button" class="btn btn-success col-sm-12">Login</button>
        <p class="m-auto text-center p-2" style="font-size:12px">Jika belum ada akun silahkan register sekarang..!</p>
        <button type="button" class="btn btn-danger col-sm-12" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
