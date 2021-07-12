<!doctype html>
<html>

<head>
    <title></title>
    <base href="<?php echo base_url() ?>">
    <link href="assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .word-table {
            border-collapse: collapse !important;
            width: 100%;
        }

        .word-table tr th,
        .word-table tr td {
            padding: 3px 5px;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2><?php echo (session("nama_perusahaan")); ?></h2>
        </div>
        <div class="col-lg-12 text-center">
            <h6><?php echo (session("alamat_perusahaan")); ?></h6>
        </div>
        <div class="col-lg-12 text-center">
            <h6><?php echo (session("telepon_perusahaan")); ?></h6>
        </div>
    </div>
    <hr>
    <div class="col-lg-12 text-center">
        <h4>Data Stok Barang</h4>
    </div>
    <?php echo (dayToString() . ", " . date("d") . " " . monthToString() . " " . date("Y")); ?>
    <hr>
    <table class="word-table" style="margin-bottom: 10px">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Barcode</th>
                <th>Nama Item</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Vendor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_master as $key => $master) : ?>
                <tr>
                    <td><?php echo ($master->kode_barang); ?></td>
                    <td><?php echo ($master->barcode); ?></td>
                    <td style="max-width: 21%;"><?php echo wordwrap($master->nama, 50, "</br>"); ?></td>
                    <td style="max-width: 11%;"><?php echo formatNUmber($master->stok) . " " . $master->nama_satuan; ?></td>
                    <td style="max-width: 11%;">Rp <?php echo formatNumber($master->harga); ?></td>
                    <td style="max-width: 12%;"><?php echo ($master->nama_kategori); ?></td>
                    <td style="max-width: 11%;"><?php echo ($master->nama_vendor); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
<script type="text/javascript">
    window.print();
    timerInterval = setInterval(() => {
        clearInterval(timerInterval);
        window.close();
    }, 3500);
</script>

</html>