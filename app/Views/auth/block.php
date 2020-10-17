<?php $this->extend('layout/template'); ?>

<?php $this->section('konten') ?>       
    <!-- Main content -->                 
            <div class="row mt-5">
                <div class="col">                    
                      <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Akses Ditolak.</h3>
            
                      <p>
                        Silahkan kembali ke halaman <?= $link == '/auth' ? 'Login.' : 'Dashboard.' ?>
                        <br>
                        <a href="<?= base_url($link) ?>">Kembali</a>
                      </p>                              
                </div>
            </div>
    <!-- /.content -->  
<?php $this->endSection(); ?>