<div class="card">
	<div class="card-header row py-2 justify-content-between">
		<div class="col-6">
			Item : <b><?= $item ?></b> barang
		</div>
		<div class="text-right col-6">
			<b>Total : Rp. <?= $amount ?></b>
		</div>
	</div>
    <div class="card-body px-3 pt-2 pb-0">
        <?php
        if ($status == 200) {
            foreach ($data as $d) {
        ?>
                <div class="row">
                    <div class="col-6 text-xs">
                        <span><?= $d['product'] ?></span>
					</div>
					<div class="col-1 text-center">
						<?= $d['qty'] ?>
					</div>
					<div class="col-2 text-right">
						<?= $d['price'] ?>
					</div>
					<div class="col-2 text-right">
						<?= $d['amount'] ?>
					</div>
					<div class="col-1 text-right text-danger">
						<i style="cursor: pointer" class="fas fa-trash" onclick="deleteDetail(<?= $d['id'] ?>)"></i>
					</div>
				</div>
                <hr class="mt-2 mb-2">
            <?php
            }
        } else {
            ?>
            <span class="text-danger text-center">Tidak ada data</span>
        <?php
        }
        ?>
    </div>
</div>
