<?php $this->extend('layout/template') ?>

<?php $this->section('konten') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Pengguna</h1>
          </div><!-- /.col -->          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">       
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Hasil : <?= count($pengguna) ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="row mt-4 mr-4">
                            <div class="col-md-4 ml-4">
                                <!-- SEARCH FORM -->
                                <form class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Cari..">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="button-addon2">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Nomor Telepon</th>
                                <th>level</th>
                                <th>Aktivasi?</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                foreach ($pengguna as $user) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $user['nama_pengguna'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td><?= $user['nomor_telepon'] ?></td>
                                        <td><?= $user['level'] ?></td>
                                        <td><?= $user['is_active'] == 1 ? '<span class="badge bg-success">Sudah Aktivasi</span>' : '<span class="badge bg-danger">Belum Aktivasi</span>' ?></td>                            
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>                  
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-center">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /col -->
            </div>  
        </div>
        <!-- /.row -->    
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<?php $this->endSection() ?>