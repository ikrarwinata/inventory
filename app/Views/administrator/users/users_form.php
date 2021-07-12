<?php
$this->extend('administrator/_templates/Container');
$this->section('content'); ?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-users"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
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
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="username">Username</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_username_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_username"); ?></small></span>
                                    <input type="text" class="form-control" autocomplete="on" name="username" id="username" maxlength="50" placeholder="Username" value="<?php echo $data->username; ?>" required="true" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_nama_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_nama"); ?></small></span>
                                    <input type="text" class="form-control" autocomplete="on" name="nama" id="nama" maxlength="50" placeholder="Nama lengkap user" value="<?php echo $data->nama; ?>" required="true" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_password_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_password"); ?></small></span>
                                    <input type="password" class="form-control" autocomplete="on" name="password" id="password" maxlength="100" placeholder="Password" value="<?php echo $data->password; ?>" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="password2">Konfirmasi Password</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_password_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_password"); ?></small></span>
                                    <input type="password" class="form-control" autocomplete="on" name="password2" id="password2" maxlength="100" placeholder="<?php echo lang("Default.Tooltips.ConfirmPassword", [], $PageAttribute["locale"]) ?>" value="<?php echo $data->password2; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_level_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_level"); ?></small></span>
                            <select class="form-control" id="level" name="level" placeholder="level">
                                <option value="admin" <?php echo inputSelect("admin", $data->level) ?>>admin</option>
                                <option value="superadmin" <?php echo inputSelect("superadmin", $data->level) ?>>superadmin</option>
                            </select>
                        </div>
                        <input type="hidden" id="oldusername" class="form-control" name="oldusername" style="display:none;" value="<?php echo $data->username ?>">
                        <div class="d-flex p-2 bd-highlight">
                            <div class="form-group">
                                <a class="btn btn-sm btn-danger" href="<?php echo base_url($PageAttribute['parent'] . '/index') ?>"><?php echo lang("Default.Button.Cancel", [], $PageAttribute["locale"]) ?></a>
                                <button class="btn btn-sm btn-primary" id="submit-button" type="submit"><?php echo lang("Default.Button.Save", [], $PageAttribute["locale"]) ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>