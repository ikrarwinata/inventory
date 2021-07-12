<?php
$this->extend('administrator/_templates/Container');
$this->section('content'); ?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-tags"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <?php if (session()->getFlashdata('ci_flash_message_id_master') != NULL) : ?>
        <div class="alert text-center mb-1 mt-0 <?php echo session()->getFlashdata('ci_flash_message_id_master_type') ?>" role="alert">
            <small><?php echo session()->getFlashdata('ci_flash_message_id_master') ?></small>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <br />
                    <form action="<?php echo $action ?>" method="post">
                        <div class="form-group">
                            <label for="id">KODE TRANSAKSI</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_id_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_id"); ?></small></span>
                            <input type="text" class="form-control" name="id" id="id" autocomplete="off" maxlength="100" placeholder="Id" value="<?php echo $data->id; ?>" required="true" />
                        </div>

                        <fieldset style="border: 1px solid rgba(6,139,168,0.67); padding: 8px;">
                            <legend><?php echo lang('Text.AssetDetail', [], $PageAttribute['locale']) ?></legend>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Scan Barcode</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_barcode_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_barcode"); ?></small></span>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control penjualan-ajax" autocomplete="off" autofocus id="barcode" maxlength="100" placeholder="Scan Barcode untuk memilih barang" value="<?php echo ($data->barcode); ?>" />
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <a href="#" class="btn btn-primary btn-md d-xl-none d-lg-none d-md-block d-sm-block d-xs-block" id="penjualan-barcode-search-btn"><i class="fa fa-search"></i></a>
                                    <small class="d-xl-block d-lg-block d-md-none d-sm-none d-xs-none d-none"><i><?php echo lang('Text.PressEnterToSeek', [], $PageAttribute['locale']) ?></i></small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">atau Cari Nama Barang</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_nama_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_nama"); ?></small></span>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input type="text" maxlength="255" id="nama" class="form-control penjualan-ajax" autocomplete="off" list="masterlist" value="<?php echo ($data->nama); ?>">
                                    <datalist id="masterlist">
                                        <?php foreach ($masterbarang as $key => $value) : ?>
                                            <option value="<?php echo ($value->nama); ?>">
                                            <?php endforeach ?>
                                    </datalist>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <a href="#" class="btn btn-primary btn-md d-xl-none d-lg-none d-md-block d-sm-block d-xs-block" id="penjualan-nama-search-btn"><i class="fa fa-search"></i></a>
                                    <small class="d-xl-block d-lg-block d-md-none d-sm-none d-xs-none d-none"><i><?php echo lang('Text.PressEnterToSeek', [], $PageAttribute['locale']) ?></i></small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <button type="button" class="btn btn-md btn-success form-control" id="penjualan-add-batch" disabled>Tambahkan</button>
                            </div>
                        </fieldset>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="40px">#</th>
                                        <th>Kode Barang</th>
                                        <th>Barcode</th>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th colspan="2">Harga</th>
                                    </tr>
                                </thead>
                                <tbody id="penjualan-batch-rows">
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="id_divisi">Divisi&nbsp;<a href="<?php echo (base_url('administrator/Divisi/create')); ?>" class="text-success" title="<?php echo lang('Default.Tooltips.Add', ['field' => 'Divisi'], $PageAttribute['locale']) ?>" onclick="return confirm('<?php echo lang('Promp.Leave', [], $PageAttribute['locale']) ?>')"><i class="fa fa-plus fa-lg"></i></a></label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_id_vendor_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_id_vendor"); ?></small></span>
                            <select name="id_divisi" id="id_divisi" class="form-control" required>
                                <?php foreach ($divisi as $key => $value) : ?>
                                    <option value="<?php echo ($value->id); ?>" <?php echo (inputSelect($value->id, $data->id_divisi)); ?>><?php echo ($value->nama_divisi); ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <input type="hidden" id="oldid" class="form-control" name="oldid" style="display:none;" value="<?php echo $data->id ?>">
                        <hr>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <a class="btn btn-sm btn-danger form-control" href="<?php echo base_url($PageAttribute['parent']) ?>"><?php echo lang("Default.Button.Cancel", [], $PageAttribute["locale"]) ?></a>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <button class="btn btn-sm btn-primary form-control" type="submit" id="penjualan-batch-validate"><?php echo lang("Default.Button.Save", [], $PageAttribute["locale"]) ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>