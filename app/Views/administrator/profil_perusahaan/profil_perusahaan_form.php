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

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <br />
                                        <form action="<?php echo $action ?>" method="post">
                            <div class="form-group">
                            <label for="key_name">Key_name</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_key_name_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_key_name"); ?></small></span>
                            <input type="text" class="form-control" autocomplete="on" name="key_name" id="key_name" maxlength="150" placeholder="Key_name" value="<?php echo $data->key_name; ?>" required="true" />
                        </div>
                        <div class="form-group">
                            <label for="values_data">Values_data</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_values_data_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_values_data"); ?></small></span>
                            <textarea class="form-control" rows="3" name="values_data" id="values_data" maxlength="65535" placeholder="Values_data" required="true" ><?php echo $data->values_data; ?></textarea>
                        </div>
                        <input type="hidden" id="oldkey_name" class="form-control" name="oldkey_name" style="display:none;" value="<?php echo $data->key_name ?>">
                        <div class="d-flex p-2 bd-highlight">
                        <div class="form-group">
                            <a class="btn btn-sm btn-danger" href="<?php echo base_url($PageAttribute['parent'].'/index') ?>"><?php echo lang("Default.Button.Cancel", [], $PageAttribute["locale"]) ?></a>
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