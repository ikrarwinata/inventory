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
                    <table class="table table-light table-striped">
                        <tbody>
                            <tr>
                                <th width="15%">username</th>
                                <td>: <?php echo $data->username; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">password</th>
                                <td>: <?php echo $data->password; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">nama</th>
                                <td>: <?php echo $data->nama; ?></td>
                            </tr>
                            <tr>
                                <th width="15%">level</th>
                                <td>: <?php echo $data->level; ?></td>
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