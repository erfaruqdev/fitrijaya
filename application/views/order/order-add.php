<?php $this->load->view('partials/header'); ?>
<input type="hidden" id="url" value="<?= base_url() ?>">
<input type="hidden" id="invoice" value="<?= $setting['invoice'] ?>">
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row justify-content-between">
			<?php if ($setting['invoice'] > 0) { ?>
				<div class="col-8 col-md-7 col-lg-7 col-xl-7 mb-2">
					<div class="callout callout-success py-1 mb-0">
						<span class="font-weight-bold"> <?= $setting['customer_name'] ?></span>
					</div>
				</div>
			<?php } else { ?>
				<div class="col-2 col-md-2 col-lg-2 col-xl-2 mb-2">
                    <a href="<?= base_url() ?>order" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-list"></i>
                    </a>
				</div>
			<?php } ?>
            	<?php if ($setting['invoice'] <= 0) { ?>
                <div class="col-8 col-md-3 col-lg-3 col-xl-3 mb-2">
                    <select id="changeCustomer" class="form-control form-control-sm select2bs4">
                        <option value="">..:Pilih Toko:..</option>
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
            <?php
            } else {
            ?>
                <div class="col-2 col-md-3 col-lg-3 col-xl-3 mb-2">
                    <button type="button" onclick="cancelOrder()" id="remove-invoice" class="btn btn-sm btn-danger btn-block">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            <?php
            }
            ?>
            <?php
            if ($setting['invoice'] <= 0) {
            ?>
                <div class="col-2 col-md-2 col-lg-2 col-xl-2 mb-3">
                    <button type="button" id="add-invoice" class="btn btn-sm btn-primary btn-block">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </div>
            <?php
            } else {
            ?>
                <div class="col-2 col-md-2 col-lg-2 col-xl-2 mb-3">
                    <button type="button" onclick="saveOrder()" class="btn btn-sm btn-primary btn-block">
                        <i class="far fa-check-circle"></i>
                    </button>
                </div>
            <?php
            }
            ?>
        </div>
        <?php if ($setting['invoice'] != 0) { ?>
            <div class="row">
                <div class="col-md-12 col-lg-5 col-xl-5 mb-3">
                    <form id="form-order" autocomplete="off">
						<div class="row mb-3">
							<div class="col-9">
								<input type="text" autofocus name="name" id="product-name" class="form-control form-control-sm" placeholder="Ketik nama barang">
							</div>
							<div class="col-3">
								<input value="0" type="number" name="qty" id="qty" class="form-control form-control-sm" placeholder="QTY">
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="row skeleton_loading_product__" style="display:none;">
									<div class="col-12">
										<div class="card skeleton mb-0" style="height: 30px"></div>
									</div>
								</div>
								<div class="card bg-light mb-0">
									<div class="card-body py-2" id="product-info" style="display: none;">
										<div class="row justify-content-around">
											<div>Stok: <span id="show-stock"></span></div>
											<div>Harga: <span id="show-price"></span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="order_id" id="order-id" value="<?= $setting['invoice'] ?>">
						<input type="hidden" name="product_id" id="product-id" value="0">
						<input type="hidden" id="price" name="price" value="0">
                    </form>
                    <button type="button" class="btn btn-primary btn-xs btn-block mt-3" id="save-order">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
                <div class="col-md-12 col-lg-7 col-xl-7">
                    <div class="row skeleton_loading__" id="skeleton_loadadd">
                        <div class="col-12">
                            <div class="card skeleton py-4 mb-3"></div>
                        </div>
                        <div class="col-12">
                            <div class="card skeleton py-4 mb-3"></div>
                        </div>
                    </div>
                    <div id="show-data" style="height: 72.5vh; overflow-y: auto; overflow-x: hidden"></div>
                </div>
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
<?php $this->load->view('order/js-order-add'); ?>
