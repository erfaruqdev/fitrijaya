<?php $this->load->view('partials/header'); ?>
<input type="hidden" id="url" value="<?= base_url() ?>">
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xl-4 mb-2"></div>
            <div class="col-md-3 col-lg-3 col-xl-3 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="reservation" placeholder="Semua waktu">
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-xl-3 mb-2">
                <input type="hidden" id="start-date" value="">
                <input type="hidden" id="end-date" value="">

                <select id="changeMarket" class="form-control form-control-sm w-100" onchange="loadData()">
                    <option value="">..:Semua Toko:..</option>
                    <?php
                    if ($market) {
                        foreach ($market as $m) {
                    ?>
                            <option value="<?= $m->id ?>"><?= $m->name ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mb-3">
                <a href="<?= base_url() ?>purchase/add" class="btn btn-sm btn-primary btn-block">
                    <i class="fas fa-plus-circle"></i> Tambah Transaksi
                </a>
            </div>
        </div>
        <div class="row skeleton_loading__">
            <div class="col-lg-4">
                <div class="card skeleton py-2 mb-3"></div>
            </div>
            <div class="col-lg-4">
                <div class="card skeleton py-2 mb-3"></div>
            </div>
            <div class="col-lg-4">
                <div class="card skeleton py-2 mb-3"></div>
            </div>
            <div class="col-lg-4">
                <div class="card skeleton py-2 mb-3"></div>
            </div>
            <div class="col-lg-4">
                <div class="card skeleton py-2 mb-3"></div>
            </div>
            <div class="col-lg-4">
                <div class="card skeleton py-2 mb-3"></div>
            </div>
        </div>
        <div class="row" id="show-data">

        </div>
    </section>
    <!-- /.content -->
</div>

<!-- LOADING -->
<div class="wrap-loading__" style="display: none">
    <div class="loading__ fade-in-loading__">
        <div class="wrapper-loading__">
            <div class="lds-dual-ring"></div>
            <span class="font-italic text-loading__">Ke pasar beli pepaya, tunggu sebentar, ya.....</span>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 justify-content-between">
                <h6 class="modal-title">Detail Transaksi</h6>
                <i class="fa fa-times mt-2" title="Tutup detail" data-dismiss="modal" style="cursor: pointer"></i>
            </div>
            <div class="modal-body p-0" id="show-detail">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php $this->load->view('partials/footer'); ?>
<script src="<?= base_url('template') ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url('template') ?>/plugins/daterangepicker/daterangepicker.js"></script>
<?php $this->load->view('purchase/js-purchase'); ?>