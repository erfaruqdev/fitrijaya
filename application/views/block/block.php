<?php $this->load->view('partials/header'); ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row mt-3">
            <div class="error-page" style="margin-top: 100px;">

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Akses dicegah....</h3>

                    <p>
                        Anda tidak punya hak akses ke halaman yang dituju. <br>
                        <br>
                        <a href="<?= base_url() ?>">Kilik untuk kembali ke Beranda</a>
                    </p>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('block/js-block'); ?>