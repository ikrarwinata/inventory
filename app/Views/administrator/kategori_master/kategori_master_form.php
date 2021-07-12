<?php
$this->extend('administrator/_templates/Container');
$this->section('content'); ?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-glass"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
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
                            <label for="nama_kategori">Nama Kategori</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_nama_kategori_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_nama_kategori"); ?></small></span>
                            <input type="text" class="form-control" autofocus autocomplete="on" name="nama_kategori" id="nama_kategori" maxlength="100" placeholder="Nama Kategori" value="<?php echo $data->nama_kategori; ?>" required="true" />
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