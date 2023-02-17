<div class="card">
    <div class="card-header">
        <h6 class="text-center">
            Data Paket
        </h6>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>OPSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($package) {
                    $no = 1;
                    foreach ($package as $d) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $d->name ?></td>
                                <td>
                                    <button onclick="editOther('<?= $d->id ?>', 'packages')" type="button" class="btn btn-sm btn-default">
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