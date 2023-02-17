<?php $this->load->view('partials/header'); ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="callout callout-success">
                    <h6 class="text-center">Pembelian</h6>
                    <table class="table table-sm">
                        <tbody>
                            <?php
                            $buy = ($data[0]) ? $data[0]->amount : 0;
                            $stock = ($data[1]) ? $data[1]->amount : 0;
                            $buyClean = $buy - $stock;
                            ?>
                            <tr>
                                <td>Pembelian bersih</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($buy, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Sisa stok</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($stock, 0, ',', '.') ?></td>
                            </tr>
                            <tr class="text-success font-weight-bold">
                                <td>HPP</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($buyClean, 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="callout callout-success">
                    <h6 class="text-center">Penjualan</h6>
                    <table class="table table-sm">
                        <tbody>
                            <?php
                            if ($data[2]) {
                                $amount = $data[2]->amount;
                                $canceled = $data[2]->canceled;
                                $discount = $data[2]->discount;
                                $retur = ($data[3]) ? $data[3]->amount : 0;

                                $total = $amount - ($canceled + $discount + $retur);
                            }
                            ?>
                            <tr>
                                <td>Penjualan kotor</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($amount, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Pembatalan penjualan</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($canceled, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Diskon penjualan</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($discount, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Retur penjualan</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($retur, 0, ',', '.') ?></td>
                            </tr>
                            <tr class="text-success font-weight-bold">
                                <td>Penjualan bersih</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($total, 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="callout callout-success">
                    <h6 class="text-center">Laba Kotor</h6>
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>Penjualan bersih</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($total, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>HPP</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($buyClean, 0, ',', '.') ?></td>
                            </tr>
                            <tr class="text-success font-weight-bold">
                                <td>Laba kotor</td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right"><?= number_format($total - $buyClean, 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('statistic/js-statistic'); ?>