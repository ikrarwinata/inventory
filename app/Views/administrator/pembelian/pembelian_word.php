<!doctype html>
<html>

<head>
    <title>Document File</title>
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
        <h4>Data Pembelian</h4>
    </div>
    <?php echo (dayToString() . ", " . date("d") . " " . monthToString() . " " . date("Y")); ?>
    <hr>
    <table class="word-table" style="margin-bottom: 10px">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Kode Barang</th>
                <th>Quantity</th>
                <th>Harga</th>
                <th>Tanggal Transaksi</th>
                <th>Suplier</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_pembelian as $key => $pembelian) : ?>
                <tr>
                    <td><?php echo ($pembelian->id); ?></td>
                    <td><?php echo ($pembelian->id_master); ?></td>
                    <td style="max-width: 10%;"><?php echo formatNUmber($pembelian->quantity); ?></td>
                    <td style="max-width: 11%;">Rp <?php echo formatNumber($pembelian->harga); ?></td>
                    <td style="max-width: 8%;"><?php echo (date("d-m-Y", $pembelian->timestamps)); ?></td>
                    <td style="max-width: 12%;"><?php echo ($pembelian->id_vendor); ?></td>
                    <td style="max-width: 11%;"><?php echo ($pembelian->username); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>