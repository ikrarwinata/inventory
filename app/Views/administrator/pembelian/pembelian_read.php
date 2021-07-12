<?php
$this->extend('administrator/_templates/Container');
$this->section('content'); ?>

<div class="row content">
    <h1><?php echo $PageAttribute["title"]; ?></h1>
</div>
<table class="table table-light table-striped">
    <tbody>
        <tr>
            <th width="15%">id</th><td>:  <?php echo $data->id; ?></td>
        </tr>
        <tr>
            <th width="15%">id_master</th><td>:  <?php echo $data->id_master; ?></td>
        </tr>
        <tr>
            <th width="15%">quantity</th><td>:  <?php echo $data->quantity; ?></td>
        </tr>
        <tr>
            <th width="15%">harga</th><td>:  <?php echo $data->harga; ?></td>
        </tr>
        <tr>
            <th width="15%">timestamps</th><td>:  <?php echo $data->timestamps; ?></td>
        </tr>
        <tr>
            <th width="15%">id_vendor</th><td>:  <?php echo $data->id_vendor; ?></td>
        </tr>
        <tr>
            <th width="15%">username</th><td>:  <?php echo $data->username; ?></td>
        </tr>
    </tbody>
</table>
    <div class="d-flex p-2 bd-highlight">
        <a class="btn btn-sm btn-danger" href="<?php echo base_url($PageAttribute['parent']) ?>"><?php echo lang("Default.Button.Cancel", [], $PageAttribute["locale"]) ?></a>
    </div>
<?php $this->endSection(); ?>