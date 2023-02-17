<?php $this->load->view('partials/header'); ?>
<?php
$username = $this->session->userdata('username');
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-4">
        <div class="row">
            <div class="col-12 col-md-12 col-sm-12 col-lg-9 pt-3 pl-5">
                <dl class="row">
                    <dt class="col-sm-2 font-weight-normal">Nama</dt>
                    <dd class="col-sm-10 font-weight-bold"><?= $this->session->userdata('name') ?></dd>
                    <dt class="col-sm-2 font-weight-normal">Username</dt>
                    <dd class="col-sm-10">
                        <?= $username ?>
                    </dd>
                    <dt class="col-sm-2 font-weight-normal">
                        <small class="text-danger mt-2 ml-3 d-none" id="errorusername">
                            <i class="fas fa-exclamation"></i>
                            <span id="is-error" class="ml-1"></span>
                        </small>
                    </dt>
                    <dd class="col-sm-10">
                        <div class="row mt-2 pl-2 d-none" id="wrap-change-username">
                            <input type="hidden" id="current_username" value="<?= $username ?>">
                            <div class="col-12 mb-2">
                                <input type="text" class="form-control form-control-sm" name="username" id="username" autocomplete="off">
                            </div>
                            <div class="col-12 mb-2">
                                <button onclick="saveUsername('<?= $username ?>')" class="btn btn-default btn-xs px-3">Simpan</button>
                                <button onclick="cancelChangeUsername()" class="btn btn-danger btn-xs px-3 ml-2">Batal</button>
                            </div>
                        </div>
                    </dd>
                    <dt class="col-sm-2 font-weight-normal">Hak Akses</dt>
                    <dd class="col-sm-10 text-primary">
                        <span class="badge badge-success">
                            <?= $this->session->userdata('text_role') ?>
                        </span>
                    </dd>
                </dl>
                <hr>
                <button class="btn btn-default btn-xs px-3" onclick="changeUsername()">
                    <i class="fas fa-user-edit"></i> Ubah Username
                </button>
                <button class="btn btn-default btn-xs px-3" onclick="showChangePasword()">
                    <i class="fas fa-key"></i> Ubah Kata Sandi
                </button>
                <div id="wrap-change-password" class="d-none">
                    <hr>
                    <div class="row">
                        <div class="col-5">
                            <form autocomplete="off" id="formchangepassword">
                                <input type="hidden" name="current_username" value="<?= $username ?>">
                                <div class="form-group">
                                    <label for="password" class="font-weight-normal">Kata Sandi Baru</label>
                                    <input type="password" class="form-control form-control-border" name="password" id="password">
                                    <small class="text-danger errors" id="errorpassword"></small>
                                    <small id="text-strength"></small>

                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation" class="font-weight-normal">Ulangi Kata Sandi Baru</label>
                                    <input type="password" class="form-control form-control-border" name="password_confirmation" id="password_confirmation">
                                    <small class="text-danger errors" id="errorpassword_confirmation"></small>
                                </div>
                                <div class="form-group">
                                    <label for="current_password" class="font-weight-normal">Kata Sandi Saat Ini</label>
                                    <input type="password" class="form-control form-control-border" name="current_password" id="current_password">
                                    <small class="text-danger errors" id="errorcurrent_password"></small>
                                </div>
                            </form>
                            <button class="btn btn-default btn-sm px-3" onclick="saveNewPassword()" id="buttonsavenewpassword">
                                Simpan Kata Sandi Baru
                            </button>
                            <button class="btn btn-danger btn-sm px-3 ml-2" onclick="cancelChangePasword()">
                                Batal
                            </button>
                        </div>
                        <div class="col-7 pl-4">
                            <small class="text-success">
                                <b>Cara buat password kuat :</b>
                                <ul>
                                    <li>Minimal 8 karakter</li>
                                    <li>Gabungan angka, huruf, dan karakter khusus</li>
                                    <li>Gabungan huruf kapital dan huruf kecil</li>
                                </ul>
                            </small>
                            <div class="mb-2 d-flex justify-content-start" id="showTogglePassword" style="cursor: pointer">
                                <small>
                                    <span>Tampilkan Password</span> <i class="fa fa-eye"></i>
                                </small>
                            </div>
                            <div class="mb-2 d-none justify-content-start" id="hideTogglePassword" style="cursor: pointer">
                                <small>
                                    <span>Sembunyikan Password</span> <i class="fa fa-eye-slash"></i>
                                </small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</div>

<!-- Modal Password Confirmation -->
<div class="modal fade" id="modal-username" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Password Konfirmasi</h6>
            </div>
            <div class="modal-body">
                <p class="text-danger">Demi keamanan, Anda harus memasukkan kata sandi</p>
                <hr>
                <form autocomplete="off" id="formshangeusername">
                    <input type="hidden" name="new_username" id="new_username" value="">
                    <div class="form-group mb-2">
                        <label for="current_password_change_username" class="font-weight-normal">Kata Sandi Saat Ini</label>
                        <input type="password" class="form-control form-control-border current_password_change_username" name="current_password_change_username" id="current_password_change_username">
                        <small class="text-danger errors" id="errorcurrent_password_change_username"></small>
                    </div>
                    <div class="mb-2 d-flex justify-content-end" id="showPassword" style="cursor: pointer">
                        <small>
                            <span>Tampilkan Password</span> <i class="fa fa-eye"></i>
                        </small>
                    </div>
                    <div class="mb-2 d-none justify-content-end" id="hidePassword" style="cursor: pointer">
                        <small>
                            <span>Sembunyikan Password</span> <i class="fa fa-eye-slash"></i>
                        </small>
                    </div>
                    <small class="text-danger" id="errorcurrent_password_change_username"></small>
                </form>
            </div>
            <div class="modal-footer justify-content-between p-2">
                <button type="button" class="btn btn-danger btn-xs px-3" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-xs px-3" id="savechangeuser">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Croping Images -->
<div class="modal fade" id="modal-change-image" aria-hidden="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <div id="image_demo"></div>
                    </div>
                    <div class="col-4">
                        <div class="d-block mb-3">
                            <button class="vanilla-rotate btn btn-sm btn-block btn-default" data-deg="-90">Putar Ke Kiri</button>
                        </div>
                        <div class="d-block mb-3">
                            <button class="vanilla-rotate btn btn-sm btn-block btn-default" data-deg="90">Putar Ke Kanan</button>
                        </div>
                        <div class="d-block mb-3">
                            <button class="btn btn-sm btn-block btn-primary" id="upload-image">Crop & Save</button>
                        </div>
                        <div class="d-block">
                            <button class="btn btn-sm btn-block btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('profile/js-profile'); ?>