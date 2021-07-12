<?php
$this->extend('administrator/_templates/Container');
$this->section('content'); ?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $PageAttribute["title"]; ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <?php if (session()->getFlashdata('ci_flash_message') != NULL) : ?>
        <div class="alert text-center mb-1 mt-0 <?php echo session()->getFlashdata('ci_flash_message_type') ?>" role="alert">
            <small><?php echo session()->getFlashdata('ci_flash_message') ?></small>
        </div>
    <?php endif; ?>

    <div class="row" style="background-color: white;">
        <div class="col-md-12 col-sm-12 " style="background-color: white;">
            <div class="x_panel" style="background-color: white;">
                <div class="x_header">
                    <button id="print_js" class="btn btn-md btn-primary pull-right"><i class="fa fa-print"></i>&nbsp;Print</button>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        Offset Tanda Tangan : <input type="number" min="15" max="99999999999" id="plc-offset" value="55">&nbsp;<small>Naikan nilai ini jika tempat tanda tangan kurang kebawah atau terlalu tinggi</small>
                    </div>                    
                </div>
                <div class="x_content" style="background-color: white;">
                    <br />
                    <span style="color: black; font-size: 22px"><strong><?php echo (session("nama_perusahaan")); ?></strong></span><br>
                    <span style="color: black; font-size: 12px"><strong>Jawa Barat</strong></span>
                    <hr style="border-bottom: 5px solid black; margin:0px;padding:0px;">
                    <hr style="border-top: 1px solid black; margin-top:3px;padding:0px;">

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <span style="color: black; font-size: 28px"><strong>BUKTI PENGELUARAN BARANG</strong></span>
                        </div>
                    </div>

                    <table width="100%" style="margin-top: 35px;">
                        <tr>
                            <td width="15%" style="color:black;"><strong>No.</strong></td>
                            <td width="45%" style="color:black;"><strong>
                                : INV<?php echo ($key.'/________/'.date("y")); ?>
                            </strong></td>
                            <td width="40%" style="color:black;" rowspan="3">
                                <strong>
                                    Kepada Yth. <br>
                                    <?php echo ($data_invoice[0]->nama_divisi); ?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%" style="color:black;"><strong>Tanggal</strong></td>
                            <td width="45%" style="color:black;"><strong>
                                : <?php echo (date("d/m/Y")); ?>
                            </strong></td>
                        </tr>
                        <tr>
                            <td width="15%" style="color:black;"><strong>Kegiatan</strong></td>
                            <td width="45%" style="color:black;"><strong>
                                : _____________________________________
                            </strong></td>
                        </tr>
                    </table>

                    <table class="table table-bordered" style="margin-top: 45px;">
                        <thead>
                            <tr>
                                <th width="18%" style="color: black;text-align: center;">Barcode</th>
                                <th width="32%" style="color: black;text-align: center;">Nama Barang</th>
                                <th width="9%" style="color: black;text-align: center;">Satuan</th>
                                <th width="10%" style="color: black;text-align: center;">Qty</th>
                                <th style="color: black;text-align: center;">Harga Satuan</th>
                                <th style="color: black;text-align: center;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            $totalqty = 0;
                            foreach($data_invoice as $key => $value):
                                $subtotal = $value->quantity * $value->harga;
                                $total += $subtotal;
                                $totalqty += $value->quantity;
                             ?>
                            <tr>
                                <td style="color: black;text-align: center;"><?php echo ($value->barcode); ?></td>
                                <td style="color: black;"><?php echo ($value->nama); ?></td>
                                <td style="color: black;text-align: center;"><?php echo ($value->nama_satuan); ?></td>
                                <td style="color: black;text-align: center;"><?php echo ($value->quantity); ?></td>
                                <td style="color: black;text-align: center;">Rp <?php echo (formatNumber($value->harga)); ?></td>
                                <td style="color: black;text-align: center;">Rp <?php echo (formatNumber($subtotal)); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="color: black;text-align: center;"><strong>Jumlah</strong></td>
                                <td style="color: black;text-align: center;"><strong><?php echo (formatNumber($totalqty)); ?></strong></td>
                                <td style="color: black;text-align: center;">-</td>
                                <td style="color: black;text-align: center;"><strong>Rp <?php echo (formatNumber($total)); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>

                    <table width="100%" style="margin-top: 55px;" id="table-signature">
                        <tr>
                            <td width="46%" style="padding-left:25px;color: black"><strong>Catatan :</strong></td>
                            <td width="2%">&nbsp;</td>
                            <td width="30%" style="text-align:center;color: black"><strong>Pemakai / Peminjam,</strong></td>
                            <td width="2%">&nbsp;</td>
                            <td width="30%" style="text-align:center;color: black"><strong>Hormat Kami,</strong></td>
                        </tr>
                        <tr height="100px">
                            <td rowspan="2" style="border: 1px solid black;">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="border-bottom: 1px solid black;">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="border-bottom: 1px solid black;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="text-align:center;color: black"><?php echo ($data_invoice[0]->nama_divisi); ?></td>
                            <td>&nbsp;</td>
                            <td style="text-align:center;color: black"></td>
                        </tr>
                    </table>
                </div>
                <div class="x_footer">
                    <div class="d-flex p-2 bd-highlight">
                        <a class="btn btn-sm btn-danger" href="<?php echo base_url($PageAttribute['parent'] . '/index') ?>"><?php echo lang("Default.Button.Close", [], $PageAttribute["locale"]) ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>