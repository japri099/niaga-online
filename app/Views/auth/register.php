<?php $this->extend('layout/template') ?>

<?php $this->section('konten') ?>
<body class="hold-transition login-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Niaga</b>11</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Sign Up</p>

      <form action="<?= base_url() ?>/auth/daftar" method="post">
        <?= $validation->hasError('nama') ? '<small class="text-danger">' . $validation->getError('nama') . '</small>' : '' ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" placeholder="Nama" name="nama" value="<?= old('nama') ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>          
        </div>
        
        <?= $validation->hasError('email') ? '<small class="text-danger">' . $validation->getError('email') . '</small>' : '' ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" name="email" placeholder="Email" value="<?= old('email') ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <?= $validation->hasError('no_telp') ? '<small class="text-danger">' . $validation->getError('no_telp') . '</small>' : '' ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control <?= $validation->hasError('no_telp') ? 'is-invalid' : '' ?>" name="no_telp" placeholder="Nomor Telepon" value="<?= old('no_telp') ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>

        <?= $validation->hasError('password') ? '<small class="text-danger">' . $validation->getError('password') . '</small>' : '' ?>
        <div class="input-group mb-3">
          <input type="password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>" name="password" placeholder="Password (Minimal 5 karakter)">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>                
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>          
        </div>
      </form>
  
      <div class="row">
        <p class="ml-4 mb-3">
          <a href="<?= base_url() ?>/" class="text-center">Saya sudah registrasi</a>
        </p>
      </div>
      
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
<?php $this->endSection() ?>