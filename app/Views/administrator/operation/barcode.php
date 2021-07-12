<?php
$this->extend('administrator/_templates/Container');
$this->section('content');
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-sitemap"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
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
                <div class="x_title">
                    <h2><?php echo lang('Text.Barcode', [], $PageAttribute['locale']) ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="<?php echo (base_url('administrator/Operation/barcode')); ?>" method="POST">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <input type="text" class="form-control" name="judul" id="judul" value="<?php echo ($judul); ?>" placeholder="Judul" list="barcodejudul" autocomplete="off">
                                <datalist id="barcodejudul">
                                    <?php foreach($listjudul as $key => $value): ?>
                                    <option value="<?php echo ($value->judul) ?>" >
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" class="form-control" name="barcode" id="barcode" value="<?php echo ($barcode); ?>" placeholder="Barcode text" list="barcode_text" autocomplete="off">
                                <datalist id="barcode_text">
                                    <?php foreach($listbarcode_text as $key => $value): ?>
                                    <option value="<?php echo ($value->barcode_text) ?>" >
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="col-lg-2 col-md-2">
                                <input type="number" class="form-control" name="repeat" id="repeat" value="<?php echo ($repeat); ?>" placeholder="Quantity">
                            </div>
                            <div class="col-lg-12 col-md-12 mt-3">
                                <button type="submit" class="btn btn-md btn-success form-control"><?php echo lang('Default.Button.Generate', [], $PageAttribute['locale']); ?></button>
                            </div>
                        </div>
                    </form>
                    
                    <?php if($barcode!=NULL): ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <a href="#" id="bc-print" class="btn btn-success btn-md form-control"><i class="fa fa-print"></i>&nbsp;Cetak Barcode</a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <a href="#" id="bcl-print" class="btn btn-primary btn-md form-control"><i class="fa fa-print"></i>&nbsp;Cetak Barcode & Label</a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <a href="#" id="l-print" class="btn btn-secondary btn-md form-control"><i class="fa fa-print"></i>&nbsp;Cetak Label</a>
                                </div>
                            </div>

                            <div id="table-print" class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tr>
                                        <th class="text-center" width="40px">#</th>
                                        <th class="text-center no-print" width="60px"><input type="checkbox" id="cb-row-parent" checked="true"></th>
                                        <th class="text-center" id="table-header-barcode">Barcode</th>
                                        <th class="text-center" id="table-header-label">Label</th>
                                        <th class="text-center" id="table-header-judul">Judul</th>
                                    </tr>
                                    <?php for($i = 0; $i < $repeat; $i++): ?>
                                    <tr class="">
                                        <td class="text-center" style="vertical-align: middle; align-self: center;"><?php echo ($i+1); ?></td>
                                        <td class="text-center no-print" style="vertical-align: middle; align-self: center;"><input type="checkbox" class="cb-row" checked="true"></td>
                                        <td class="text-center table-col-barcode">
                                            <?php echo ($judul); ?><br>
                                            <img alt="barcode" src="<?php echo (base_url('Api/barcode_image?codetype=Code39&size=40&text='.$barcode." ".($i+1))); ?>"/><br>
                                            <?php echo ($barcode." ".($i+1)); ?>
                                        </td>
                                        <td class="text-center table-col-label"><?php echo ($barcode."<br>".($i+1)); ?></td>
                                        <td class="text-center table-col-judul"><?php echo ($judul); ?></td>
                                    </tr>
                                    <?php endfor; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>;