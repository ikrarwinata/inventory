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
        <h4>Data Vendor</h4>
    </div>
    <?php echo (dayToString() . ", " . date("d") . " " . monthToString() . " " . date("Y")); ?>
    <hr>
    <table class="word-table" style="margin-bottom: 10px">
        <thead>
            <tr>
                <th>ID Vendor</th>
                <th>Nama Vendor</th>
                <th>Kota</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_vendor as $key => $vendor) : ?>
                <tr>
                    <td><?php echo ($vendor->id); ?></td>
                    <td style="max-width: 11%;"><?php echo ($vendor->nama_vendor); ?></td>
                    <td><?php echo ($vendor->kota); ?></td>
                    <td><?php echo ($vendor->telepon); ?></td>
                    <td style="max-width: 25%;"><?php echo wordwrap($vendor->alamat, 50, "</br>"); ?></td>
                    <td style="max-width: 25%;"><?php echo wordwrap($vendor->keterangan, 50, "</br>"); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>