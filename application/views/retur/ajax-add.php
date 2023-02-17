<?php if ($data['status'] == 400) { ?>
    <div class="alert alert-danger" role="alert">
        <?= $data['message'] ?>
    </div>
<?php } else { ?>
    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-12">
                    <small>Pesanan dari :
                        <span class="text-primary"><?= $data['customer'] ?></span>
                    </small>
                </div>
            </div>
        </div>
        <div class="card-body pt-2 pb-0" style="height: 68.5vh; overflow-y: auto">
            <?php
            foreach ($data['data'] as $d) {
            ?>
                <div class="row">
                    <div class="col-11">
                        <span class="text-xs"><?= $d['product'] ?></span> <br>
                        <form id="form-retur-<?= $d['id'] ?>">
                            <div class="row pl-3">
                                <div class="col-4 text-primary">
                                    <?= $d['qty'] ?>
                                </div>
                                <input type="hidden" name="invoice" value="<?= $data['invoice'] ?>">
                                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                <input type="hidden" name="customer" value="<?= $data['customer_id'] ?>">
                                <div class="col-4">
                                    <input type="number" name="package" class="form-control form-control-sm form-control-border" placeholder="Paket" value="0">
                                </div>
                                <div class="col-4">
                                    <input type="number" name="unit" class="form-control form-control-sm form-control-border" placeholder="Satuan" value="0">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if ($d['status'] != 'RETURED') { ?>
                        <div class="col-1 text-right" style="cursor: pointer" onclick="returOrder(<?= $d['id'] ?>)">
                            <div class="">
                                <i class="fas fa-undo text-danger"></i>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <hr class="mt-2 mb-3">
            <?php } ?>
        </div>
    </div>
<?php } ?>