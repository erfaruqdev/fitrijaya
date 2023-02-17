<?php
if ($status == 200) {
?>
    <table class="table table-sm mb-0">
        <thead>
            <tr>
                <th>NO</th>
                <th>MMU</th>
                <th>PJGB</th>
                <th>GB</th>
                <th class="text-center">POIN</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data as $d) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <span class="text-success"><?= $d->name ?></span> <br>
                        <small><?= $d->village . ', ' . $d->city ?></small>
                    </td>
                    <td><?= $d->pjgb ?></td>
                    <td><?= $d->gb ?></td>
                    <td class="text-center"><?= $d->points ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php
} else {
?>
    <div class="error-page">
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Ada masalah nih</h3>
            <p>
                <?= $data ?>. <br>
            </p>
        </div>
    </div>
<?php
}
?>