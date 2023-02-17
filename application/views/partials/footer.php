<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
    </div>
    <?php
    $currentYear = date('Y');

    ?>
    <strong>Copyright &copy; <?= (date('Y') != $currentYear) ? $currentYear . '-' : '' ?><?= $currentYear ?> </strong><span class="text-default"> - Rahman Faruq</span>
</footer>

</div>
<!-- jQuery -->
<script src="<?= base_url() ?>template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= base_url() ?>template/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="<?= base_url() ?>template/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>template/plugins/jquery-lazy/jquery.lazy.min.js"></script>
<script src="<?= base_url() ?>template/plugins/jquery-lazy/plugins/jquery.lazy.ajax.min.js"></script>
<script src="<?= base_url() ?>template/plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>template/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url() ?>template/plugins/toastr/toastr.min.js"></script>
<script src="<?= base_url() ?>template/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script>
    function formatErrorMessage(jqXHR, exception) {
        if (jqXHR.status === 0) {
            return ('Tidak ada koneksi internet.\nCek lagi jaringanmu.');
        } else if (jqXHR.status == 404) {
            return ('Halaman yang diminta tidak ditemukan.');
        } else if (jqXHR.status == 401) {
            return ('Sesi kamu sudah habis.\nCoba login lagi');
        } else if (jqXHR.status == 500) {
            return ('Server lagi ada masalah.');
        } else if (exception === 'parsererror') {
            return ('Requested JSON parse failed.');
        } else if (exception === 'timeout') {
            return ('Permitaan terlalu lama.');
        } else if (exception === 'abort') {
            return ('Ajax request aborted.');
        } else {
            return ('Unknown error occured. Please try again.');
        }
    }
</script>