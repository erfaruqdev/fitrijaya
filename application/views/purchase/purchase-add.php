<?php $this->load->view('partials/header'); ?>
<input type="hidden" id="url" value="<?= base_url() ?>">
<input type="hidden" id="invoice" value="<?= $setting['invoice'] ?>">
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row">
            <div class="col-md-7 col-lg-7 col-xl-7 mb-2">
                <?php if ($setting['invoice'] > 0) { ?>
                    <h6 class="mb-0">Transaksi Pembelian di <span class="text-primary"> <?= $setting['market_name'] ?></span></h6>
                    <small>Invoice Number : <b><?= $setting['invoice'] ?></b></small>
                <?php } else { ?>
                    <a href="<?= base_url() ?>purchase" class="btn btn-primary btn-sm px-5">
                        <i class="fas fa-list"></i> Lihat data
                    </a>
                <?php } ?>
            </div>
            <div class="col-6 col-md-3 col-lg-3 col-xl-3 mb-2">
                <?php if ($setting['invoice'] <= 0) { ?>
                    <select id="changeMarket" class="form-control form-control-sm w-100">
                        <option value="">..:Pilih Toko:..</option>
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
                <?php
                } else {
                ?>
                    <button type="button" onclick="cancelTransaction()" id="remove-invoice" class="btn btn-xs btn-danger btn-block">
                        <i class="fa fa-trash"></i> Batalkan Transaksi
                    </button>
                <?php
                }
                ?>
            </div>
            <div class="col-6 col-md-2 col-lg-2 col-xl-2 mb-3">
                <?php
                if ($setting['invoice'] <= 0) {
                ?>
                    <button type="button" id="add-invoice" class="btn btn-sm btn-primary btn-block">
                        <i class="fa fa-plus-circle"></i> Buat Nomor Faktur
                    </button>
                <?php
                } else {
                ?>
                    <button type="button" onclick="saveTransaction()" class="btn btn-xs btn-success btn-block">
                        <i class="far fa-check-circle"></i> Selesaikan
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
        <?php if ($setting['invoice'] != 0) { ?>
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-4 mb-3">
                    <form id="form-transaction" autocomplete="off">
                        <input type="text" name="name" id="product-name" class="form-control form-control-sm mb-3" placeholder="Ketik nama barang">
                        <input type="hidden" name="purchase_id" value="<?= $setting['invoice'] ?>">
                        <input type="hidden" name="product_id" id="product-id" value="0">
                        <div class="row">
                            <div class="col-4">
                                <input type="number" name="qty" id="qty" class="form-control form-control-sm" placeholder="QTY">
                            </div>
                            <div class="col-8">
                                <input type="text" name="nominal" id="nominal" class="form-control form-control-sm" placeholder="Nominal">
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-primary btn-xs btn-block mt-3" id="save-transaction">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
                <div class="col-md-12 col-lg-8 col-xl-8" id="show-data"></div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-12">
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-exclamation-circle fa-5x text-danger"></i>
                        <h6 class="pt-4">Opppss..! Pilih toko dan buat nomor faktur untuk memulai transaksi</h6>
                    </div>
                </div>
            </div>
        <?php } ?>
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

<?php $this->load->view('partials/footer'); ?>
<script src="<?= base_url('template') ?>/plugins/autoNumeric.js"></script>
<?php $this->load->view('purchase/js-purchase-add'); ?>