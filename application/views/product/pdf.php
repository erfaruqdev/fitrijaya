<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/logo.png">
    <style>
        * {
            font-family: 'Segoe UI', Courier, monospace;
            /* font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; */
            font-size: 11pt;
        }

        .container {
            width: 800px;
            display: relative;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .col-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-7 {
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-5 {
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-3 {
            flex: 0 0 23%;
            max-width: 23%;
            padding-right: 5px;
            padding-left: 5px;
        }

        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .logo {
            width: 55%;
            margin-top: 8px;
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

        h4 {
            font-size: 1.2rem;
        }

        .invoice-title {
            font-size: 3rem;
            color: #999797;
        }

        .card-title {
            font-size: 2.5rem;
        }

        .text-right {
            text-align: end;
        }

        hr {
            margin-top: 0.6rem;
            margin-bottom: 0.6rem;
            border: 0;
            border-top: 1px solid rgb(0 0 0 / 82%)
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            background-color: #65b73d;
            color: white;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mt-1 {
            margin-top: 1rem;
        }

        .mt-2 {
            margin-top: 3rem;
        }

        .mb-1 {
            margin-bottom: 1rem;
        }

        .mb-2 {
            margin-bottom: 2rem;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .notes {
            padding-left: 25px;
            padding-top: 10px;
        }

        .pt-2 {
            padding-top: 0.5rem;
        }

        .border {
            background-color: #181616;
            height: 1px;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .text-left {
            text-align: start;
        }

        .card {
            box-shadow: 0 0 6px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
            padding: 15px;
            border-radius: 5px;
        }

        .product {
            width: 100%;
            border-radius: 5px;
            border: 1px solid #999797;
        }

        hr {
            border-top: 1px solid rgb(161 161 161 / 82%);
        }

        .caption {
            font-size: 10pt;
            color: #484646;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <img class="logo" src="<?= base_url() ?>assets/images/header-print-color.png" alt="">
            </div>
        </div>
        <div class="border"></div>
        <div class="row">
            <div class="col-12 text-center mb-1">
                <h4>DAFTAR PRODUK [<?= $amount ?>]</h4>
            </div>
            <?php
            if ($data) {
                foreach ($data as $d) {
                    $imagePath = FCPATH . 'assets/images/products/' . $d->image;

                    if (file_exists($imagePath) === FALSE || $imagePath == NULL || $d->image == NULL) {
                        $avatar = base_url('assets/images/products/404.png');
                    } else {
                        $avatar = base_url('assets/images/products/' . $d->image);
                    }
            ?>
                    <div class="col-3 mb-1">
                        <div class="card">
                            <img src="<?= $avatar ?>" alt="" class="product">
                            <h6 class="text-center mt-1">
                                <?= $d->name ?>
                            </h6>
                            <div class="text-center caption"><?= $d->package ?> [<?= $d->unit_amount . ' - ' . $d->unit ?>]</div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>

</html>