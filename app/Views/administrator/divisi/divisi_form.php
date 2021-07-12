<?php
$this->extend('administrator/_templates/Container');
$this->section('content'); ?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-clone"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
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
                    <form action="<?php echo $action ?>" method="post">
                        <div class="form-group">
                            <label for="id">ID Divisi</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_id_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_id"); ?></small></span>
                            <input type="text" class="form-control" autocomplete="on" name="id" id="id" maxlength="100" placeholder="Id" value="<?php echo $data->id; ?>" required="true" />
                        </div>
                        <div class="form-group">
                            <label for="nama_divisi">Nama Divisi</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_nama_divisi_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_nama_divisi"); ?></small></span>
                            <input type="text" class="form-control" autocomplete="on" name="nama_divisi" id="nama_divisi" maxlength="255" placeholder="Nama Divisi/User" value="<?php echo $data->nama_divisi; ?>" required="true" />
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="kota">Kota</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_kota_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_kota"); ?></small></span>
                                    <input type="text" class="form-control" autocomplete="on" name="kota" id="kota" maxlength="100" placeholder="Kota Divisi/User" value="<?php echo $data->kota; ?>" required="true" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_telepon_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_telepon"); ?></small></span>
                                    <input type="tel" class="form-control" autocomplete="on" name="telepon" id="telepon" maxlength="50" placeholder="Telepon Divisi/User" value="<?php echo $data->telepon; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_alamat_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_alamat"); ?></small></span>
                            <textarea class="form-control" rows="3" name="alamat" id="alamat" maxlength="65535" placeholder="Alamat"><?php echo $data->alamat; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_keterangan_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_keterangan"); ?></small></span>
                            <textarea class="form-control" rows="3" name="keterangan" id="keterangan" maxlength="65535" placeholder="Keterangan"><?php echo $data->keterangan; ?></textarea>
                        </div>
                        <input type="hidden" id="oldid" class="form-control" name="oldid" style="display:none;" value="<?php echo $data->id ?>">
                        <div class="d-flex p-2 bd-highlight">
                            <div class="form-group">
                                <a class="btn btn-sm btn-danger" href="<?php echo base_url($PageAttribute['parent'] . '/index') ?>"><?php echo lang("Default.Button.Cancel", [], $PageAttribute["locale"]) ?></a>
                                <button class="btn btn-sm btn-primary" type="submit"><?php echo lang("Default.Button.Save", [], $PageAttribute["locale"]) ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>