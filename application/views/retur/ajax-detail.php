<div class="card mb-0">
    <div class="card-body p-0 pb-2" style="max-height: 60.2vh; overflow: auto;">
        <table class="table table-head-fixed table-hover table-sm">
            <tbody>
                <?php
                if ($data) {
                    foreach ($data as $d) {
                ?>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-12">
                                        <small><?= $d->name ?></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <small class="text-center"><?= $d->qty ?></small>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-right"><?= number_format($d->nominal, 0, ',', '.') ?></small>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-right"><?= number_format($d->amount, 0, ',', '.') ?></small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td class="text-center">
                            <b class="text-danger">Tidak ada data</b>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>