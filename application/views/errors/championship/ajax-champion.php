<div class="form-group row">
    <div class="col-12">
        <?php
        if ($status == 200) {
        ?>
            <div class="alert alert-success alert-dismissible py-2 px-3 mb-0">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <table class="w-100 text-sm">
                    <tr>
                        <td>
                            <?php
                            foreach ($data as $d) {
                                echo $d->name . '<br>';
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?= $mmu ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger alert-dismissible py-2 px-3 mb-0">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-exclamation-triangle"></i> Oppsss..! <br>
                <span><?= $data ?></span>
            </div>
        <?php } ?>
    </div>
</div>