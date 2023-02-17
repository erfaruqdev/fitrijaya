<?php $this->load->view('partials/header'); ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 pr-2">
                        <h6 class="card-title mt-1">Data Menu</h6>
                        <button data-toggle="modal" data-target="#modal-menu" type="button" class="btn btn-sm btn-primary float-right" id="adduser">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Menu
                        </button>
                        <select onchange="getdata()" id="changeStatus" class="form-control form-control-sm float-right mr-2" style="width: 150px">
                            <option value="">..:Semua Status:..</option>
                            <option value="ACTIVE">AKTIF</option>
                            <option value="INACTIVE">NON AKTIF</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="showmenu"></div>
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-menu" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Form Tambah Menu</h6>
                <div class="align-middle" data-dismiss="modal" title="Tutup" style="cursor: pointer">
                    <i class="fas fa-times-circle text-danger"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="formmenu" autocomplete="off">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control form-control-border text-capitalize" id="name">
                        <small class="text-danger errors" id="errorname"></small>
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" name="icon" class="form-control form-control-border" id="icon">
                        <small class="text-danger errors" id="erroricon"></small>
                    </div>
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" name="url" class="form-control form-control-border" id="url">
                        <small class="text-danger errors" id="errorurl"></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end p-2">
                <button type="button" class="btn btn-primary btn-sm" id="savemenu">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('menu/js-menu'); ?>