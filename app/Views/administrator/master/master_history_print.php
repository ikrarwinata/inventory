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
        <h4>History Barang</h4>
    </div>
    <?php echo (dayToString() . ", " . date("d") . " " . monthToString() . " " . date("Y")); ?>
    <hr>
    <table class="word-table" style="margin-bottom: 10px">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Kode Barang</th>
                <th>Quantity</th>
                <th>Nilai Transaksi</th>
                <th>Tanggal</th>
                <th>Vendor/Divisi</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_master as $key => $master) : ?>
                <tr>
                    <td><?php echo ($master->id); ?></td>
                    <td><?php echo ($master->id_master); ?></td>
                    <td style="max-width: 7%;"><?php echo ($master->operators . $master->quantity); ?></td>
                    <td style="max-width: 11%;">Rp <?php echo formatNumber($master->harga); ?></td>
                    <td style="max-width: 12%;"><?php echo date("d-m-Y", $master->timestamps); ?></td>
                    <td style="max-width: 11%;"><?php echo ($master->id_suplier); ?></td>
                    <td style="max-width: 11%;"><?php echo ($master->username); ?></td>
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