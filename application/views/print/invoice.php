<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.png">
    <style>
        * {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
			/*font-family: 'Courier New', Courier, monospace;*/
			/*font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;*/
            font-size: 9pt;
        }

        .container {
            width: 80mm;
            display: relative;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0.1rem;
            margin-bottom: 0.1rem;
            margin-block-start: 0px;
            margin-block-end: 0px;
            font-family: inherit;
            font-weight: bold;
            color: inherit;
        }

        .text-right {
            text-align: end;
        }

        hr {
            border: 0;
            border-top: 1px dashed rgb(22 22 22 / 82%)
        }

        table {
            border-collapse: collapse;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            background-color: transparent;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .tablestripped th {
            vertical-align: top;
            border-top: 1px solid #999797;
            border-bottom: 1px solid #999797;
        }

        .tablestripped td {
            vertical-align: top;
            border-top: 1px dashed #999797;
        }

        .tablebottom td,
        .tablebottom th {
            vertical-align: top;
            border-top: 1px dashed #999797;
        }

        .table-xl th {
            padding: 0.5rem;
        }

        .table-xl td {
            padding: 0.3rem;
        }

        .table-sm td,
        .table-sm th {
            padding: 0.2rem;
        }

        .text-center {
            text-align: center;
        }
		.mb-1 {
			margin-bottom: 4px;
		}

		@page {
			margin: 0;
		}
    </style>
</head>

<body>
    <div class="container">
		<div class="print-area">
			<?php if ($data['status'] == 200) { ?>
				<div class="row">
					<div class="col-12 text-center">
						<p class="mb-1">
							<b style="font-size: 13pt">TOKO RIZKY BAROKAH</b> <br>
							Jl. Masjid Al-Amin, Palengaan Daja <br>
							Palengaan Pamekasan, 087886750002
						</p>
					</div>
				</div>
				<hr>
				<table class="table mb-0">
					<?php if ($data['customer'] !== 'UMUM') { ?>
						<tr>
							<td>Pelanggan</td>
							<td><b><?= $data['customer'] ?></b</td>
						</tr>
					<?php } ?>
					<tr>
						<td>No. Faktur</td>
						<td><?= $data['id'] ?></td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td>
							<?= $data['date'] ?>
						</td>
					</tr>
				</table>
				<hr>
				<table class="table mb-0">
					<tbody>
					<?php
					$no = 1;
					foreach ($data['data'] as $d) {
						?>
						<tr>
							<td><?= $d['product'] ?></td>
							<td class="text-center"><?= $d['qty'] ?></td>
							<td class="text-right"><?= number_format($d['price'], 0, ',', '.') ?></td>
							<td class="text-right"><?= number_format($d['amount'], 0, ',', '.') ?></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
				<hr>
				<div class="text-center">
					Total <b><?= $data['item'] ?></b> item dari <b><?= $data['count'] ?></b> macam barang
				</div>
				<hr>
				<table class="table mb-0">
					<tr>
						<td style="width: 60%">Total</td>
						<td style="width: 5%">Rp.</td>
						<td class="text-right" style="width: 35%">
							<?= number_format($data['amount'], 0, ',', '.') ?>
						</td>
					</tr>
					<tr>
						<td>Diskon</td>
						<td>Rp.</td>
						<td class="text-right">
							<?= number_format($data['discount'], 0, ',', '.') ?>
						</td>
					</tr>
					<tr>
						<td>Jumlah</td>
						<td>Rp.</td>
						<td class="text-right">
							<?= number_format($data['nominal'], 0, ',', '.') ?>
						</td>
					</tr>
				</table>
				<hr>
				<div class="row">
					<div class="col-12">
						<i>
							NOTE! Retur barang harus tunjukkan nota
						</i>
					</div>
				</div>
			<?php } else { ?>
				<div class="row">
					<div class="col-12">
						<i>ERRORRR<i> <br>
								<i><?= $data['message'] ?> </i>
					</div>
				</div>
			<?php } ?>
		</div>
    </div>
	<script>
		window.print()
		// window.onafterprint = function () {
		// 	window.close()
		// }
	</script>
</body>

</html>
