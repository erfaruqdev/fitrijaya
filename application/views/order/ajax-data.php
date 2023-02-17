<?php
$status = [
    'LATER' => '<span class="badge badge-warning">- Tempo</span>',
    'DONE' => '<span class="badge badge-warning">- Lunas</span>'
];
if ($datas) {
    $no = 1;
    foreach ($datas as $data) {
?>
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header text-xs">
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-receipt"></i>
                            <?= $data->id ?>
                        </div>
                        <div class="col-6">
                            <?= datetimeIDFormat($data->updated_at) ?>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2 pb-3">
                    <div class="row">
						<div class="col-10" title="Klik untuk lihat detail" style="cursor: pointer" onclick="detailTransaction(<?= $data->id ?>)">
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
									Rp. <?= number_format($data->amount, 0, ',', '.') ?> <br>
									<i><?= $status[$data->status]; ?></i>
								</div>
							</div>
						</div>
						<div class="col-2">
							<a href="<?= base_url() ?>order/printout/<?= encrypt_url($data->id) ?>" class="btn btn-xs btn-default btn-block" target="_blank">
								Print
							</a>
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
