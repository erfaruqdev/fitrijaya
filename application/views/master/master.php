<?php $this->load->view('partials/header'); ?>
<input type="hidden" id="url" value="<?= base_url() ?>">
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2"></div>
            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
                <button type="button" class="btn mr-2 btn-sm btn-primary btn-block" id="add-button">
                    <i class="fa fa-plus-circle"></i>
                    Tambah Toko | Pelanggan
                </button>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
                <button type="button" class="btn mr-2 btn-sm btn-primary btn-block" id="add-other">
                    <i class="fa fa-plus-circle"></i>
                    Tambah Data Lainnya
                </button>
            </div>
        </div>
        <div class="row">
            <section class="col-md-5 col-xl-5">
                <div class="col-12" id="show-category">
                    <div class="card skeleton skeleton_loading_category__ py-5 mb-3"></div>
                </div>
    
                <div class="col-12" id="show-color">
                    <div class="card skeleton skeleton_loading_color__ py-5 mb-3"></div>
                </div>
    
                <div class="col-12" id="show-package">
                    <div class="card skeleton skeleton_loading_package__ py-5 mb-3"></div>
                </div>

                <div class="col-12" id="show-unit">
                    <div class="card skeleton skeleton_loading_unit__ py-5 mb-3"></div>
                </div>
            </section>

            <section class="col-md-7 col-xl-7">
                <div class="col-12" id="show-market">
                    <div class="card skeleton skeleton_loading_market__ py-5 mb-3"></div>
                </div>
    
                <div class="col-12" id="show-customer">
                    <div class="card skeleton skeleton_loading_customer__ py-5 mb-3"></div>
                </div>
            </section>

        </div>
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

<div class="modal fade" id="modal-master" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 justify-content-end">
                <h6 class="modal-title">Tambah Data Toko/Pelanggan</span></h6>
            </div>
            <form id="form-master" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="0">
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Jenis</label>
                        <div class="col-sm-7 form-feedback">
                            <select name="table" id="table" class="form-control">
                                <option value="">.:Pilih:.</option>
                                <option value="markets">Toko</option>
                                <option value="customers">Pelanggan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Nama</label>
                        <div class="col-sm-7 form-feedback">
                            <input type="text" name="name" id="name" class="form-control text-uppercase">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Alamat</label>
                        <div class="col-sm-7 form-feedback">
                            <textarea name="address" id="address" class="form-control text-capitalize"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-5 col-form-label">No. HP</label>
                        <div class="col-sm-7 form-feedback">
                            <input type="text" name="phone" id="phone" class="form-control" data-inputmask="'mask' : '999-999-999-999'" data-mask="">
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

<div class="modal fade" id="modal-other" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <div class="modal-header py-2 justify-content-end">
                <h6 class="modal-title">Tambah Data Lainnya</h6>
            </div>
            <form id="form-other" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id-other" value="0">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis</label>
                        <div class="col-sm-9 form-feedback">
                            <select name="table" id="table-other" class="form-control">
                                <option value="">.:Pilih:.</option>
                                <option value="categories">Kategori</option>
                                <option value="colors">Warna</option>
                                <option value="packages">Paket</option>
                                <option value="units">Satuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9 form-feedback">
                            <input type="text" name="name" id="name-other" class="form-control text-capitalize">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between p-2">
                    <button type="button" class="btn btn-danger btn-sm px-5" data-dismiss="modal">Batal</button>
                    <button type="submit" id="submit-other" class="btn btn-primary btn-sm px-5">Simpan</button>
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
<?php $this->load->view('master/js-master'); ?>