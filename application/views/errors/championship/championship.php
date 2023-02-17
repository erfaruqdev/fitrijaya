<?php $this->load->view('partials/header'); ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
                <select id="changeCategory" class="form-control w-100" onchange="loadData()">
                    <option value="">..:Kategori:..</option>
                    <option value="1">PUTRA</option>
                    <option value="2">PUTRI</option>
                </select>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-2">
                <select id="changeContest" class="form-control w-100" onchange="loadData()">
                    <option value="">..:Pilih:..</option>
                    <?php
                    foreach ($contest as $c) {
                    ?>
                        <option value="<?= $c->id ?>"><?= $c->name ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-2">
                <form action="<?= base_url() ?>championship/printchampions" target="_blank" method="POST">
                    <input type="hidden" name="category" id="category-result-champion" value="">
                    <input type="hidden" name="contest" id="contest-result-champion" value="">
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fa fa-print"></i> Print Out
                    </button>
                </form>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-2">
                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-point">
                    <i class="fa fa-award"></i> Poin Umum
                </button>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-champion">
                    <i class="fa fa-plus-circle"></i> Tambah Juarawan
                </button>
            </div>
        </div>
        <div class="row" id="show-data-champion"></div>
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-champion" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Form Juarawan</h6>
            </div>
            <div class="modal-body">
                <form id="form-champion" autocomplete="off">
                    <div class="form-group row">
                        <label for="contest" class="col-sm-5 col-form-label">Jenis Lomba</label>
                        <div class="col-sm-7">
                            <select id="contest" name="contest" class="form-control w-100" onchange="changeContest(this)">
                                <option value="">..:Pilih:..</option>
                                <?php
                                foreach ($contest as $c) {
                                ?>
                                    <option value="<?= $c->id ?>"><?= $c->name ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Juara Pertama</label>
                        <div class="col-sm-7">
                            <input type="text" id="rank-1" name="rank[1]" class="form-control text-uppercase" tabindex="1" data-inputmask="'mask' : '9999999999'" data-mask="">
                        </div>
                    </div>
                    <div id="show-data-rank-1"></div>
                    <div class="form-group row" id="content-rank-2">
                        <label class="col-sm-5 col-form-label">Juara Kedua</label>
                        <div class="col-sm-7">
                            <input type="text" id="rank-2" name="rank[2]" class="form-control text-uppercase" tabindex="2" data-inputmask="'mask' : '9999999999'" data-mask="">
                        </div>
                    </div>
                    <div id="show-data-rank-2"></div>
                    <div class="form-group row" id="content-rank-3">
                        <label class="col-sm-5 col-form-label">Juara Ketiga</label>
                        <div class="col-sm-7">
                            <input type="text" id="rank-3" name="rank[3]" class="form-control text-uppercase" tabindex="3" data-inputmask="'mask' : '9999999999'" data-mask="">
                        </div>
                    </div>
                    <div id="show-data-rank-3"></div>
                </form>
            </div>
            <div class="modal-footer justify-content-between p-2">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                <button type="button" id="button-save" class="btn btn-primary btn-sm" onclick="save()">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-point" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title w-75">Daftar Poin Juara Umum</h6>
                <select onchange="loadDataPoint()" id="changeCategoryPoin" class="form-control form-control-sm w-25">
                    <option value="">..:Kategori:..</option>
                    <option value="1">PUTRA</option>
                    <option value="2">PUTRI</option>
                </select>
            </div>
            <div class="modal-body">
                <div id="show-data-point"></div>
            </div>
            <div class="modal-footer justify-content-between p-2">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                <form action="<?= base_url() ?>championship/print" target="_blank" method="POST">
                    <input type="hidden" name="category" id="category-result" value="">
                    <button type="submit" disabled class="btn btn-primary btn-sm" id="button-print">
                        <i class="fa fa-print"></i> Print Out
                    </button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('championship/js-championship'); ?>