<?php
if ($product) {
?>
    <div class="row justify-content-center mt-2 mb-1">
        <div class="col-md-3 col-lg-3 col-xl-3">
            <div class="card">
                <div class="card-body py-1 text-center">
                    <span>Total : <b> <?= $amount ?></b> produk</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        $no = 1;
        foreach ($product as $data) {
        ?>
                <div class="col-md-6 col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-9 col-md-10 col-lg-10 col-xl-10">
                                    <div class="row align-middle">
                                        <div class="col-12">
                                            <b><?= $data->name .' '.strtoupper($data->color).' '.convertSize($data->size, $data->category_id) ?></b>
                                        </div>
                                        <div class="col-12 text-xs text-black-50">
                                            <?= $data->package ?> ( <?= $data->amount . ' ' . $data->unit ?> )
                                        </div>
                                        <div class="col-12">
                                            <div class="row justify-content-between px-2">
												<div class="text-black">
													<?= number_format($data->price_three, 0, ',', '.') ?>
												</div>
												<div class="text-black">
													<?= number_format($data->price_two, 0, ',', '.') ?>
												</div>
												<div class="text-black">
													<?= number_format($data->price, 0, ',', '.') ?>
												</div>
                                                <div class="text-xs text-black">
                                                    Stock : <?= $data->stock.' - '.$data->unit ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 col-md-2 col-lg-2 col-xl-2">
                                    <button onclick="editProduct(<?= $data->id ?>, 'COPY')" type="button" class="btn btn-default btn-xs btn-block">
                                        Salin
                                    </button>
                                    <button onclick="deleteProduct(<?= $data->id ?>)" type="button" class="btn btn-primary btn-xs btn-block">
                                        Hapus
                                    </button>
                                    <button type="button" title="Edit data" onclick="editProduct(<?= $data->id ?>, 'EDIT')" class="btn btn-success btn-xs btn-block">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }
        ?>
    </div>
<?php
}else {
?>
<div class="row">
    <div class="col-12 text-center pt-5">
        <i class="fas fa-exclamation-triangle text-danger fa-3x mb-4"></i> <br>
        <i> Oops! Belum ada produk, nih....</i>
    </div>
</div>
<?php
}
?>
