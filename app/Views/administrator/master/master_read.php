<?php
$this->extend('administrator/_templates/Container');
$this->section('content'); ?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-cubes"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <?php if (session()->getFlashdata('ci_flash_message') != NULL) : ?>
        <div class="alert text-center mb-1 mt-0 <?php echo session()->getFlashdata('ci_flash_message_type') ?>" role="alert">
            <small><?php echo session()->getFlashdata('ci_flash_message') ?></small>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <br />
                    <table class="table table-light table-striped">
                        <tbody>
                            <tr>
                                <th width="15%">Kode Barang</th>
                                <td>: <?php echo $data->kode_barang; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Barcode</th>
                                <td>: <?php echo $data->barcode; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Nama Item</th>
                                <td>: <?php echo $data->nama; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Stok</th>
                                <td>: <?php echo $data->stok; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Harga satuan</th>
                                <td>: Rp <?php echo formatNumber($data->harga); ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Kategori</th>
                                <td>: <?php echo $data->nama_kategori; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Satuan</th>
                                <td>: <?php echo $data->nama_satuan; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Berat satuan (Gram/Kilo Gram)</th>
                                <td>: <?php echo ($data->berat >= 1000 ? formatNumber($data->berat / 1000) . " Kg" : formatNumber($data->berat) . " G") ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Kadaluarsa</th>
                                <td>: <?php echo date("d-m-Y", $data->kadaluarsa); ?></td>
                            </tr>
                            <tr>
                                <th width="15%">Posisi</th>
                                <?php 
                                $posisi = isset($data->gedung)?$data->gedung:NULL;
                                $posisi .= isset($data->ruangan)?", " . $data->ruangan:NULL;
                                $posisi .= isset($data->posisi)?", " . $data->posisi:NULL;
                                 ?>
                                <td>: <?php echo($posisi); ?></td>
                            </tr>
                            <?php if(isset($data->foto) && $data->foto != ''): ?>
                            <tr>
                                <th width="15%">Foto Barang</th>
                                <td>: <a href="<?php echo base_url($data->foto); ?>" target="_blank"><img src="<?php echo base_url($data->foto); ?>" alt="-" style="max-height:250px; max-width:450px;"></a></td>
                            </tr>                            
                            <?php endif; ?>
                            <tr>
                                <th width="15%">Nama Suplier</th>
                                <td>: <?php echo $data->nama_vendor; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="x_footer">
                    <div class="d-flex p-2 bd-highlight">
                        <a class="btn btn-sm btn-danger" href="<?php echo base_url($PageAttribute['parent'] . '/index') ?>"><?php echo lang("Default.Button.Cancel", [], $PageAttribute["locale"]) ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>