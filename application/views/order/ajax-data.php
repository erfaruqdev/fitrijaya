<?php
$status = [
	'LATER' => '<span class="badge badge-warning">Tempo</span>',
	'DONE'  => '<span class="badge badge-success">Lunas</span>'
];
?>

	<style>
		.transaction-card {
			border-radius: 12px;
			border: 1px solid #e9ecef;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
			transition: 0.2s ease;
			margin-bottom: 16px;
		}

		.transaction-card:hover {
			box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
		}

		.transaction-card .card-header {
			background: #fff;
			border-bottom: 1px solid #f1f3f5;
			padding: 10px 14px;
			font-size: 12px;
			color: #6c757d;
		}

		.transaction-id {
			font-weight: 600;
			color: #343a40;
		}

		.transaction-date {
			text-align: right;
		}

		.transaction-card .card-body {
			padding: 14px;
		}

		.transaction-click {
			cursor: pointer;
			border-radius: 8px;
		}

		.transaction-customer {
			font-weight: 600;
			color: #212529;
			margin-bottom: 4px;
			line-height: 1.3;
		}

		.transaction-address {
			font-size: 12px;
			color: #6c757d;
			line-height: 1.4;
			word-break: break-word;
		}

		.transaction-summary {
			text-align: right;
		}

		.transaction-amount {
			font-weight: 700;
			color: #212529;
			font-size: 15px;
			margin-bottom: 6px;
			line-height: 1.3;
		}

		.transaction-action {
			display: flex;
			justify-content: flex-end;
			align-items: flex-start;
			height: 100%;
		}

		.btn-action {
			border-radius: 8px;
		}

		.dropdown-menu {
			border-radius: 10px;
			border: 1px solid #e9ecef;
			box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
			min-width: 170px;
		}

		.dropdown-item {
			font-size: 13px;
		}

		.desktop-action {
			display: flex;
		}

		.mobile-action {
			display: none;
		}

		@media (max-width: 767.98px) {
			.transaction-date {
				text-align: left;
				margin-top: 4px;
			}

			.transaction-summary {
				text-align: left;
				margin-top: 12px;
			}

			.transaction-action {
				justify-content: flex-start;
				margin-top: 12px;
			}

			.desktop-action {
				display: none;
			}

			.mobile-action {
				display: flex;
				gap: 8px;
				width: 100%;
			}

			.mobile-action .btn {
				flex: 1;
			}
		}
	</style>

<?php if ($datas) { ?>
	<?php foreach ($datas as $data) { ?>
		<div class="col-12 col-md-6 col-lg-6 col-xl-6">
			<div class="card transaction-card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-12 col-sm-6">
                            <span class="transaction-id">
                                <i class="fas fa-receipt mr-1"></i>
                                <?= $data->id ?>
                            </span>
						</div>
						<div class="col-12 col-sm-6 transaction-date">
							<?= datetimeIDFormat($data->updated_at) ?>
						</div>
					</div>
				</div>

				<div class="card-body">
					<div class="row align-items-start">
						<div class="col-12 col-md-10 transaction-click" title="Klik untuk lihat detail" onclick="detailTransaction(<?= $data->id ?>)">
							<div class="row">
								<div class="col-12 col-md-8">
									<div class="transaction-customer">
										<?= $data->customer ?>
									</div>
									<div class="transaction-address">
										<?= $data->address ?>
									</div>
								</div>

								<div class="col-12 col-md-4 transaction-summary">
									<div class="transaction-amount">
										Rp. <?= number_format($data->amount, 0, ',', '.') ?>
									</div>
									<?= $status[$data->status] ?? '<span class="badge badge-secondary">Unknown</span>' ?>
								</div>
							</div>
						</div>

						<div class="col-12 col-md-2">
							<div class="transaction-action">
								<!-- Desktop: dropdown -->
								<div class="btn-group desktop-action">
									<button type="button" class="btn btn-sm btn-light btn-action px-2 dropdown-toggle" data-toggle="dropdown">
									</button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li>
											<a href="<?= base_url() ?>order/printout/<?= encrypt_url($data->id) ?>" class="dropdown-item" target="_blank">
												Print Out
											</a>
										</li>
										<li>
											<a href="<?= base_url() ?>order/printdiff/<?= encrypt_url($data->id) ?>" class="dropdown-item" target="_blank">
												Print Selisih
											</a>
										</li>
										<li>
											<button type="button" class="dropdown-item text-danger" onclick="cancelTransaction('<?= $data->id ?>')">
												Batalkan transaksi
											</button>
										</li>
									</ul>
								</div>

								<!-- Mobile: print + more -->
								<div class="mobile-action">
									<a href="<?= base_url() ?>order/printout/<?= encrypt_url($data->id) ?>" target="_blank" class="btn btn-sm btn-light btn-action">
										<i class="fas fa-print mr-1"></i> Print
									</a>

									<div class="btn-group flex-fill">
										<button type="button" class="btn btn-sm btn-light btn-action w-100 dropdown-toggle" data-toggle="dropdown">
											<i class="fas fa-ellipsis-h mr-1"></i> More
										</button>
										<ul class="dropdown-menu dropdown-menu-right w-100">
											<li>
												<button type="button" class="dropdown-item text-danger" onclick="cancelTransaction('<?= $data->id ?>')">
													Batalkan transaksi
												</button>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php } else { ?>
	<div class="col-12 text-center py-5">
		<i class="fas fa-exclamation-circle fa-5x text-danger"></i>
		<h6 class="pt-4">Opppss..! Tidak ada data untuk dimuat...</h6>
	</div>
<?php } ?>
