<?php $this->load->view('partials/header'); ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content p-3">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success">
                        <i class="fas fa-boxes"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Produk</span>
                        <span class="info-box-number"><?= ($data[0]) ? $data[0]->total : 0 ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="callout callout-success">
                    <h6 class="text-center mb-3">5 Top Produk</h6>
                    <table width="100%" class="table table-sm mb-0">
                        <?php
                        if ($data[1]) {
                            $no = 1;
                            foreach ($data[1] as $t) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $t->name ?></td>
                                    <td><?= $t->amount ?> pcs</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="callout callout-danger">
                    <h6 class="text-center mb-3">5 Penjualan Terendah</h6>
                    <table width="100%" class="table table-sm mb-0">
                        <?php
                        if ($data[2]) {
                            $no = 1;
                            foreach ($data[2] as $b) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $b->name ?></td>
                                    <td><?= $b->amount ?> pcs</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php $this->load->view('partials/footer'); ?>
<?php $this->load->view('home/js-home'); ?>