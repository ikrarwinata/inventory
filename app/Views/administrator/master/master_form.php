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
                    <?php echo form_open_multipart($action); ?>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="id">Kode Barang</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_id_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_id"); ?></small></span>
                                    <input type="text" class="form-control" autocomplete="off" name="id" id="id" maxlength="100" placeholder="Id" value="<?php echo $data->id; ?>" required="true" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="barcode">Barcode</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_barcode_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_barcode"); ?></small></span>
                                    <input type="text" class="form-control" autocomplete="off" name="barcode" id="barcode" maxlength="100" placeholder="Barcode" value="<?php echo $data->barcode; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Item</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_nama_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_nama"); ?></small></span>
                            <input type="text" class="form-control" autocomplete="off" name="nama" id="nama" maxlength="255" placeholder="Nama" value="<?php echo $data->nama; ?>" required="true" />
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="harga">Harga satuan</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_harga_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_harga"); ?></small></span>
                                    <input type="number" class="form-control" name="harga" id="harga" value="<?php echo $data->harga; ?>" required="true" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="stok">Stok</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_stok_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_stok"); ?></small></span>
                                    <input type="number" class="form-control" name="stok" id="stok" value="<?php echo $data->stok; ?>" required="true" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="kategori">Kategori&nbsp;<a href="<?php echo (base_url('administrator/Kategori_master/create')); ?>" class="text-success" onclick="return confirm('<?php echo lang('Promp.Leave', [], $PageAttribute['locale']) ?>')" title="<?php echo lang('Text.CreateCategory', [], $PageAttribute['locale']) ?>"><i class="fa fa-plus fa-lg"></i></a></label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_satuan_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_satuan"); ?></small></span>
                                    <select class="form-control" id="kategori" name="kategori" placeholder="Kategori">
                                        <?php foreach ($kategori as $key => $value) : ?>
                                            <option value="<?php echo ($value->id); ?>" <?php echo (inputSelect($value->id, $data->kategori)); ?>><?php echo ($value->nama_kategori); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="satuan">Satuan&nbsp;<a href="<?php echo (base_url('administrator/Satuan_master/create')); ?>" class="text-success" onclick="return confirm('<?php echo lang('Promp.Leave', [], $PageAttribute['locale']) ?>')" title="<?php echo lang('Text.CreateUnits', [], $PageAttribute['locale']) ?>"><i class="fa fa-plus fa-lg"></i></a></label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_satuan_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_satuan"); ?></small></span>
                                    <select class="form-control" id="satuan" name="satuan" placeholder="satuan">
                                        <?php foreach ($satuan as $key => $value) : ?>
                                            <option value="<?php echo ($value->id); ?>" <?php echo (inputSelect($value->id, $data->satuan)); ?>><?php echo ($value->nama_satuan); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="berat">Berat <small>(g)</small></label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_berat_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_berat"); ?></small></span>
                                    <input type="number" class="form-control" name="berat" id="berat" value="<?php echo $data->berat; ?>" required="true" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="berat">Gedung </label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_gedung_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_gedung"); ?></small></span>
                                    <input type="text" maxlength="250" class="form-control" name="gedung" placeholder="Nama gedung" list="listgedung" autocomplete="off" value="<?php echo ($data->gedung); ?>">
                                    <datalist id="listgedung">
                                        <?php foreach($gedung as $key => $value): ?>
                                        <option value="<?php echo ($value->gedung); ?>" <?php echo(inputSelect($value->gedung, $data->gedung)); ?> >
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="berat">Ruangan </label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_ruangan_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_ruangan"); ?></small></span>
                                    <input type="text" maxlength="250" class="form-control" name="ruangan" placeholder="Nama ruangan" list="listruangan" autocomplete="off" value="<?php echo ($data->ruangan); ?>">
                                    <datalist id="listruangan">
                                        <?php foreach($ruangan as $key => $value): ?>
                                        <option value="<?php echo ($value->ruangan); ?>" <?php echo(inputSelect($value->ruangan, $data->ruangan)); ?> >
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="berat">Posisi </label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_posisi_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_posisi"); ?></small></span>
                                    <input type="text" maxlength="250" class="form-control" name="posisi" placeholder="Posisi barang" list="listposisi" autocomplete="off" value="<?php echo ($data->posisi); ?>">
                                    <datalist id="listposisi">
                                        <?php foreach($posisi as $key => $value): ?>
                                        <option value="<?php echo ($value->posisi); ?>" <?php echo(inputSelect($value->posisi, $data->posisi)); ?> >
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="kadaluarsa">Tanggal Kadaluarsa</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_kadaluarsa_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_kadaluarsa"); ?></small></span>
                                    <input type="date" class="form-control" name="kadaluarsa" id="kadaluarsa" value="<?php echo $data->kadaluarsa; ?>" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="id_vendor">Nama vendor</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_id_vendor_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_id_vendor"); ?></small></span>
                                    <select class="form-control" id="id_vendor" name="id_vendor">
                                        <?php foreach ($vendor as $key => $value) : ?>
                                            <option value="<?php echo ($value->id); ?>" <?php echo (inputSelect($value->id, $data->id_vendor)); ?>><?php echo ($value->nama_vendor); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_foto_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_foto"); ?></small></span>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <input type="hidden" id="oldfoto" class="hide hidden d-none" name="oldfoto" style="display:none;" value="<?php echo(isset($data->foto)?$data->foto:NULL); ?>">
                                    <input type="file" name="foto" id="foto" accept="*" class="form-control"  >
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <?php if (isset($data->foto) && $data->foto != NULL): ?>
                                        <a href="<?php echo base_url($data->foto); ?>" target="_blank"><img src="<?php echo base_url($data->foto); ?>" alt="-" style="max-height:250px; max-width:450px;"></a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="oldid" class="form-control" name="oldid" style="display:none;" value="<?php echo $data->oldid ?>">
                        <input type="hidden" name="oldbarcode" id="oldbarcode" value="<?php echo $data->barcode; ?>" />
                        <div class="d-flex p-2 bd-highlight">
                            <div class="form-group">
                                <a class="btn btn-sm btn-danger" href="<?php echo base_url($PageAttribute['parent']) ?>"><?php echo lang("Default.Button.Cancel", [], $PageAttribute["locale"]) ?></a>
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