<?php $this->load->view('partials/header'); ?>
<input type="hidden" id="url" value="<?= base_url() ?>">
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row justify-content-end">
            <div class="col-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="reservation" placeholder="Semua waktu">
                </div>
            </div>
            <div class="col-7 col-md-3 col-lg-3 col-xl-3 mb-2">
                <input type="hidden" id="start-date" value="">
                <input type="hidden" id="end-date" value="">

                <select id="changeCustomer" class="form-control form-control-sm w-100 select2bs4" onchange="loadData()">
                    <option value="">..:Semua Toko:..</option>
                    <?php
                    if ($customer) {
                        foreach ($customer as $c) {
                    ?>
                            <option value="<?= $c->id ?>"><?= $c->name ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-5 col-md-2 col-lg-2 col-xl-2 mb-3">
                <button class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#modal-retur">
                    <i class="fas fa-plus-circle"></i> Tambah
                </button>
            </div>
        </div>
        <div class="row skeleton_loading__">
            <div class="col-lg-6">
                <div class="card skeleton py-5 mb-3"></div>
            </div>
            <div class="col-lg-6">
                <div class="card skeleton py-5 mb-3"></div>
            </div>
            <div class="col-lg-6">
                <div class="card skeleton py-5 mb-3"></div>
            </div>
            <div class="col-lg-6">
                <div class="card skeleton py-5 mb-3"></div>
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

<div class="modal fade" id="modal-retur">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 justify-content-between">
                <h6 class="modal-title">Form Retur Barang</h6>
                <i class="fa fa-times mt-2" title="Tutup detail" data-dismiss="modal" style="cursor: pointer"></i>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="input-group">
                            <input type="number" id="invoice" class="form-control" maxlength="14">
                            <span class="input-group-append">
                                <button onclick="checkTransaction()" type="button" class="btn btn-info">Cek Sekarang</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" id="show-retur"></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 justify-content-between">
                <h6 class="modal-title">Detail Retur</h6>
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
<?php $this->load->view('retur/js-retur'); ?>