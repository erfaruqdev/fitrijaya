<div class="card">
    <div class="card-header">
        <h6 class="text-center">
            Data Satuan
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
                if ($unit) {
                    $no = 1;
                    foreach ($unit as $d) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $d->name ?></td>
                                <td>
                                    <button onclick="editOther('<?= $d->id ?>', 'units')" type="button" class="btn btn-sm btn-default">
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