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
                    <h2><?php echo lang('Text.CustomizePrice', [], $PageAttribute['locale']) ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <small><i><strong>Masukan nilai yang di inginkan kemudian tekan <?php echo lang('Default.Button.Save', [], $PageAttribute['locale']) ?></strong></i></small>
                    <hr>
                    <?php echo (form_open(site_url($PageAttribute["parent"] . "/pricing_action"))); ?>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Naikan Harga Barang sebesar :</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_barcode_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_barcode"); ?></small></span>
                        <div class="col-md-6 col-sm-6">
                            <input type="number" class="form-control" autocomplete="off" autofocus name="change_value" min="0" max="99999999999" placeholder="Masukan nilai yang di inginkan" value="" required />
                            <input type="hidden" name="intval" value="+">
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <button type="submit" class="btn btn-md btn-success form-control" onclick="return confirm('<?php echo lang('Promp.ChangePriceUp', [], $PageAttribute['locale']) ?>')"><?php echo lang('Default.Button.Save', [], $PageAttribute['locale']) ?></button>
                        </div>
                    </div>
                    </form>
                    <hr>
                    <?php echo (form_open(site_url($PageAttribute["parent"] . "/pricing_action"))); ?>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Kurangi Harga Barang sebesar :</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_barcode_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_barcode"); ?></small></span>
                        <div class="col-md-6 col-sm-6">
                            <input type="number" class="form-control" autocomplete="off" autofocus name="change_value" min="0" max="99999999999" placeholder="Masukan nilai yang di inginkan" value="" required />
                            <input type="hidden" name="intval" value="-">
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <button type="submit" class="btn btn-md btn-success form-control" onclick="return confirm('<?php echo lang('Promp.ChangePriceDown', [], $PageAttribute['locale']) ?>')"><?php echo lang('Default.Button.Save', [], $PageAttribute['locale']) ?></button>
                        </div>
                    </div>
                    </form>
                    <hr>
                    <?php echo (form_open(site_url($PageAttribute["parent"] . "/pricing_action"))); ?>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Ubah semua Harga Barang menjadi :</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_barcode_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_barcode"); ?></small></span>
                        <div class="col-md-6 col-sm-6">
                            <input type="number" class="form-control" autocomplete="off" autofocus name="change_value" min="0" max="99999999999" placeholder="Masukan nilai yang di inginkan" value="" required />
                            <input type="hidden" name="intval" value="set">
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <button type="submit" class="btn btn-md btn-success form-control" onclick="return confirm('<?php echo lang('Promp.ChangePrice', [], $PageAttribute['locale']) ?>')"><?php echo lang('Default.Button.Save', [], $PageAttribute['locale']) ?></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>;