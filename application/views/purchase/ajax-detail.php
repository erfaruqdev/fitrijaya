<div class="card mb-0">
    <div class="card-body p-0 pb-2" style="max-height: 60.2vh; overflow: auto;">
        <table class="table table-head-fixed table-hover table-sm">
            <thead>
                <tr>
                    <th>PRODUK</th>
                    <th>QTY</th>
                    <th colspan="2">HARGA</th>
                    <th colspan="2">JUMLAH</th>
                    <th class="text-center">STATUS</th>
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
                            <td>
                                <small><?= $d['qty'] ?></small>
                            </td>
                            <td>
                                <small>Rp. </small>
                            </td>
                            <td class="text-right">
                                <small><?= $d['nominal'] ?></small>
                            </td>
                            <td>
                                <small>Rp. </small>
                            </td>
                            <td class="text-right">
                                <small><?= $d['amount'] ?></small>
                            </td>
                            <td class="text-center">
                                <?= $d['status'] ?>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td class="text-center" colspan="7">
                            <b class="text-danger">Tidak ada data</b>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer row justify-content-between py-2">
        <div class="col-lg-6 text-center text-lg-left">
            Item : <b><?= $item ?> barang</b>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <b>Total : Rp. <?= $amount ?></b>
        </div>
    </div>
</div>