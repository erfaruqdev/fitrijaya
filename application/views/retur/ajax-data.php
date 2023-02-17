<?php
$status = [
    'ORDERED' => '<span class="badge badge-warning">- Menunggu konfirmasi</span>',
    'APPROVED' => '<span class="badge badge-warning">- Menunggu pengiriman</span>',
    'DELIVERED' => '<span class="badge badge-primary">- Sedang dikirim</span>',
    'DONE' => '<span class="badge badge-success">- Transaksi selesai</span>',
];
if ($datas) {
    $no = 1;
    foreach ($datas as $data) {
?>
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header text-xs">
                    <div class="row">
                        <div class="col-12">
                            <i class="fas fa-receipt"></i>
                            <?= dateTimeShortenFormat($data->created_at) ?>
                        </div>
                    </div>
                </div>
                <div class="card-body py-2" title="Klik untuk lihat detail" style="cursor: pointer" onclick="detailTransaction(<?= $data->id ?>)">
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-12">
                                    <span><?= $data->customer ?></span>
                                </div>
                                <div class="col-12">
                                    <small><?= $data->address ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-xs">
                            <?= $data->qty . '/' . $data->item . ' Item' ?>
                            <br>
                            <b class="text-success"> Rp. <?= number_format($data->amount, 0, ',', '.') ?></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
} else {
    ?>
    <div class="col-12 text-center py-5">
        <i class="fas fa-exclamation-circle fa-5x text-danger"></i>
        <h6 class="pt-4">Opppss..! Tidak ada data untuk dimuat...</h6>
    </div>
<?php
}
?>