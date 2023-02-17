<div class="card">
    <div class="card-header">
        <h6 class="text-center">
            Data Pelanggan
        </h6>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>HP</th>
                    <th>OPSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($customer) {
                    $no = 1;
                    foreach ($customer as $d) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $d->name ?></td>
                                <td><?= $d->phone ?></td>
                                <td>
                                    <button onclick="editMaster('<?= $d->id ?>', 'customers')" type="button" class="btn btn-sm btn-default">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>