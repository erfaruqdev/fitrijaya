<div class="card">
    <div class="card-body p-0 pb-2" style="max-height: 60.2vh; overflow: auto;">
        <table class="table table-head-fixed table-hover table-sm">
            <thead>
                <tr>
                    <th>PRODUK</th>
                    <th>QTY</th>
                    <th>HARGA</th>
                    <th>JUMLAH</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-right">OPSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($status == 200) {
                    foreach ($data as $d) {
                ?>
                        <tr>
                            <td>
                                <small><?= $d['product'] ?></small>
                            </td>
                            <td class="text-center">
                                <small><?= $d['qty'] ?></small>
                            </td>
                            <td class="text-right">
                                <small><?= $d['nominal'] ?></small>
                            </td>
                            <td class="text-right">
                                <small><?= $d['amount'] ?></small>
                            </td>
                            <td class="text-center">
                                <?= $d['status'] ?>
                            </td>
                            <td class="text-right">
                                <small style="cursor: pointer" class="text-danger" onclick="deleteDetail(<?= $d['id'] ?>)">Batal</small>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td class="text-center" colspan="8">
                            <b class="text-danger">Tidak ada data</b>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer row py-2 justify-content-between">
        <div class="col-lg-6">
            Item : <b><?= $item ?></b> barang
        </div>
        <div class="text-right col-lg-6">
            <b>Total : Rp. <?= $amount ?></b>
        </div>
    </div>
</div>