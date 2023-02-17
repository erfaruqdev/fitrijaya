<div class="col-12">
    <div class="card" style="height: 69.1vh;">
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 100%;" id="cardScroll">
            <table class="table table-head-fixed table-hover">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>INVOICE</th>
                        <th>TOKO</th>
                        <th colspan="2">JUMLAH</th>
                        <th class="text-center">OPSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($datas) {
                        $no = 1;
                        foreach ($datas as $data) {
                    ?>
                            <tr>
                                <td class="align-middle"><?= $no++ ?></td>
                                <td class="align-middle">
                                    <b> <?= $data->id ?></b>
                                    <br>
                                    <small class="text-success">
                                        <?= datetimeIDFormat($data->created_at) ?>
                                    </small>
                                </td>
                                <td class="align-middle">
                                    <?= $data->market ?>
                                    <br>
                                    <small class="text-success">
                                        <?= $data->address ?>
                                    </small>
                                </td>
                                <td class="align-middle">
                                    Rp.
                                </td>
                                <td class="align-middle text-right">
                                    <?= number_format($data->amount, 0, ',', '.') ?>
                                </td>
                                <td class="align-middle text-center">
                                    <button onclick="detailTransaction(<?= $data->id ?>)" class="btn btn-default btn-xs px-3" title="Lihat detail">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo '<tr class="text-center"><td colspan="6"><h6 class="text-danger">Tak ada data untuk ditampilkan</h6></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer justify-content-between">
            Total Transaksi : <b><?= $amount ?> | Rp. <?= number_format($total, 0, ',', '.') ?></b>
        </div>
    </div>
</div>