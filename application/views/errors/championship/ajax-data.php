<div class="col-12">
    <div class="card" style="height: 71.8vh;">
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 100%;" id="cardScroll">
            <table class="table table-head-fixed table-hover">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>PESERTA</th>
                        <th>MMU</th>
                        <th>LOMBA</th>
                        <th>KATEGORI</th>
                        <th class="text-center">JUARA</th>
                        <th class="text-center">POIN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($data) {
                        $no = 1;
                        $categories = [1 => 'PUTRA', 'PUTRI'];
                        foreach ($data as $d) {
                    ?>
                            <tr>
                                <td class="align-middle"><?= $no++ ?></td>
                                <td class="align-middle">
                                    <small>
                                        <?php
                                        $contestants = $this->cm->getContestant($d->school_id, $d->contest_id, $d->category);
                                        if ($contestants) {
                                            foreach ($contestants as $c) {
                                        ?>
                                                <li><?= $c->name ?></li>
                                        <?php
                                            }
                                        } else {
                                            echo '<li>Peserta kosong</li>';
                                        }
                                        ?>
                                    </small>
                                </td>
                                <td class="align-middle">
                                    <small>
                                        <span class="text-success">
                                            <?= $d->name ?> <br>
                                        </span>
                                        <?= $d->village . ', ' . $d->city ?>
                                    </small>
                                </td>
                                <td class="align-middle">
                                    <?= $d->contest ?>
                                </td>
                                <td class="align-middle">
                                    <?= $categories[$d->category] ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?= $d->rank ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?= $d->point ?>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo '<tr class="text-center"><td colspan="7"><h6 class="text-danger">Tak ada data untuk ditampilkan</h6></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer justify-content-between">
            Total : <b><?= $amount ?></b> Orang
        </div>
    </div>
</div>