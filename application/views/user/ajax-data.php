<div class="col-12">
    <div class="card" style="height: 71.8vh;">
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 100%;" id="cardScroll">
            <table class="table table-head-fixed table-hover">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th colspan="2" class="text-center">NAMA</th>
                        <th>STATUS</th>
                        <th>OPSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($datas) {
                        $no = 1;
                        foreach ($datas as $data) {
                            $avatarPath = FCPATH . 'assets/images/users/' . $data->id . '.jpg';

                            if (file_exists($avatarPath) === FALSE || $avatarPath == NULL) {
                                $avatar = base_url('assets/images/users/default.png');
                            } else {
                                $avatar = base_url('assets/images/users/' . $data->id . '.jpg');
                            }

                            $role = $data->role;
                            if ($role == 'ADMIN') {
                                $icon = 'fas fa-user-cog';
                                $textRole = 'ADMIN';
                            } elseif ($role == 'STAFF') {
                                $icon = 'fas fa-user-edit';
                                $textRole = 'STAF ADMIN';
                            } else {
                                $icon = 'fas fa-users';
                                $textRole = str_replace('-', ' ', $role);
                            }

                            $status = $data->status;
                            if ($status == 'ACTIVE') {
                                $classStatus = 'success';
                                $text = 'AKTIF';
                            } else {
                                $classStatus = 'danger';
                                $text = 'NON-AKTIF';
                            }

                    ?>
                            <tr>
                                <td class="align-middle"><?= $no++ ?></td>
                                <td>
                                    <img style="border-radius: 5px;" alt="Foto <?= $data->name ?>" width="45px" class="table-avatar" src="<?= $avatar ?>">
                                </td>
                                <td class="align-middle">
                                    <b><?= $data->name ?></b>
                                    <br>
                                    <small class="text-success"><i class="<?= $icon ?>"></i> <?= $textRole ?></small>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-<?= $classStatus ?>"><?= $text ?></span>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group">
                                        <button onclick="updateStatus(<?= $data->id ?>, 'ACTIVE')" <?= ($status == 'ACTIVE') ? 'disabled' : '' ?> type="button" class="btn btn-default btn-sm" title="Aktifkan Pengguna Ini">
                                            <i class="fas fa-user-check text-success"></i>
                                        </button>
                                        <button onclick="updateStatus(<?= $data->id ?>, 'INACTIVE')" <?= ($status != 'ACTIVE') ? 'disabled' : '' ?> type="button" class="btn btn-default btn-sm" title="Non-Aktifkan Pengguna Ini">
                                            <i class="fas fa-user-slash text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo '<tr class="text-center"><td colspan="5"><h6 class="text-danger">Tak ada data untuk ditampilkan</h6></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <b>Total Pengguna : <?= $amount ?> orang<b>
        </div>
    </div>
</div>