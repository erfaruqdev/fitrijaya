<?php $this->load->view('partials/header'); ?>
<input type="hidden" id="url" value="<?= base_url() ?>">
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row mb-2">
            <div class="col-6 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                <input type="text" autocomplete="off" id="changeName" class="form-control form-control-sm w-100" placeholder="Cara nama (F2)" autofocus onkeyup="loadData()">
            </div>
            <div class="col-6 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
                <select id="changeCategory" onchange="loadData()" class="form-control form-control-sm w-100" style="width: 150px">
                    <option value="">..:Semua Kategori:..</option>
                    <?php
                    if ($categories) {
                        foreach ($categories as $category) {
                    ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
                <a href="<?= base_url() ?>product/pdf" target="_blank" class="btn mr-2 btn-sm btn-success btn-block">
                    <i class="fa fa-download"></i>
                    Export to PDF
                </a>
            </div>
            <div class="col-6 col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-2">
                <button type="button" class="btn mr-2 btn-sm btn-success btn-block" data-toggle="modal" data-target="#modal-product">
                    <i class="fa fa-plus-circle"></i>
                    Tambah Barang
                </button>
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
        <div id="show-product"></div>
    </section>
    <!-- /.content -->
    <div class="wrap-loading__" style="display: none">
        <div class="loading__ fade-in-loading__">
            <div class="wrapper-loading__">
                <div class="lds-dual-ring"></div>
                <span class="font-italic text-loading__">Ke pasar beli pepaya, tunggu sebentar, ya.....</span>
            </div>
        </div>
    </div>
</div>

<div id="modal-image" class="modal-image">
    <span class="close" id="close">&times;</span>
    <img class="modal-content-image" id="modal-content-image" width="50px">
</div>

<div class="modal fade" id="modal-product" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 justify-content-end">
                <h6 class="modal-title">Tambah Barang</h6>
            </div>
            <form id="form-product" autocomplete="off" enctype="multipart/form-data" action="#">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="0">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Barang</label>
                        <div class="col-sm-8 form-feedback">
                            <input type="text" name="name" id="name" class="form-control text-capitalize">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category" class="col-sm-4 col-form-label">Kategori</label>
                        <div class="col-sm-8 form-feedback">
                            <select name="category" id="category" class="form-control">
                                <option value="">.:Pilih Kategori:.</option>
                                <?php
                                if ($categories) {
                                    foreach ($categories as $category) {
                                ?>
                                        <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="package" class="col-sm-4 col-form-label">Paket</label>
                        <div class="col-sm-8 form-feedback">
                            <select name="package" id="package" class="form-control">
                                <option value="">.:Pilih Paket:.</option>
                                <?php
                                if ($packages) {
                                    foreach ($packages as $package) {
                                ?>
                                        <option value="<?= $package->id ?>"><?= $package->name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit" class="col-sm-4 col-form-label">Satuan</label>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-8 col-sm-8 mb-sm-0 form-feedback">
                                    <select name="unit" id="unit" class="form-control">
                                        <option value="">.:Pilih Satuan:.</option>
                                        <?php
                                        if ($units) {
                                            foreach ($units as $unit) {
                                        ?>
                                                <option value="<?= $unit->id ?>"><?= $unit->name ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-4 col-sm-4 mb-sm-0 form-feedback">
                                    <input type="number" id="amount" name="amount" class="form-control text-capitalize">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit" class="col-sm-4 col-form-label">Warna | Ukuran</label>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-6 col-sm-8 mb-3 mb-sm-0 form-feedback">
                                    <select name="color" id="color" class="form-control">
                                        <option value="">.:Warna:.</option>
                                        <?php
                                        if ($colors) {
                                            foreach ($colors as $color) {
                                        ?>
                                                <option value="<?= $color->name ?>"><?= $color->name ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 col-sm-4 mb-sm-0 form-feedback">
                                    <select name="size" id="size" class="form-control">
                                        <option value="">.:Ukuran:.</option>
                                        <?php
                                        for ($i=0; $i <= 35; $i++) {
                                            ?>
                                            <option value="<?= $i ?>"><?= convertSize($i) ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label for="unit" class="col-sm-4 col-form-label">Grosir | Lembaga | Eceran</label>
                        <div class="col-sm-8">
                            <div class="row">
								<div class="col-4 mb-sm-0 form-feedback">
									<input type="text" class="form-control price" onfocusin="selectValue(this)" name="price_three" id="price-three" value="0">
								</div>
								<div class="col-4 mb-sm-0 form-feedback">
									<input type="text" class="form-control price" onfocusin="selectValue(this)" name="price_two" id="price-two" value="0">
								</div>
                                <div class="col-4 mb-sm-0 form-feedback">
                                    <input type="text" class="form-control price" onfocusin="selectValue(this)" name="price" id="price" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between p-2">
                    <button type="button" class="btn btn-danger btn-sm px-5" data-dismiss="modal">Batal</button>
                    <button type="submit" id="submit-button" class="btn btn-primary btn-sm px-5">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->load->view('partials/footer'); ?>
<script src="<?= base_url() ?>template/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>template/plugins/jquery-validation/additional-methods.min.js"></script>
<?php $this->load->view('product/js-product'); ?>
