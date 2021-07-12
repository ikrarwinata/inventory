    <fieldset style="border: 1px solid rgba(6,139,168,0.67); padding: 8px; margin: 8px;">
        <div class="form-group">
            <label for="id_master">Kode Barang</label>
            <input type="text" class="form-control" autocomplete="off" name="id_master" id="id_master" maxlength="100" value="<?php echo (generateId('ASST')); ?>" required />
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="kategori">Kategori</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_kategori_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_kategori"); ?></small></span>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <?php foreach ($kategori as $key => $value) : ?>
                            <option value="<?php echo ($value->id); ?>"><?php echo ($value->nama_kategori); ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="satuan">Satuan</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_satuan_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_satuan"); ?></small></span>
                    <select name="satuan" id="satuan" class="form-control" required>
                        <?php foreach ($satuan as $key => $value) : ?>
                            <option value="<?php echo ($value->id); ?>"><?php echo ($value->nama_satuan); ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="berat">Gedung </label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_gedung_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_gedung"); ?></small></span>
                    <input type="text" maxlength="250" class="form-control" name="gedung" placeholder="Nama gedung" list="listgedung" autocomplete="off" value="">
                    <datalist id="listgedung">
                        <?php foreach($gedung as $key => $value): ?>
                        <option value="<?php echo ($value->gedung); ?>" <?php echo(inputSelect($value->gedung, $gedung)); ?> >
                        <?php endforeach; ?>
                    </datalist>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="berat">Ruangan </label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_ruangan_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_ruangan"); ?></small></span>
                    <input type="text" maxlength="250" class="form-control" name="ruangan" placeholder="Nama ruangan" list="listruangan" autocomplete="off" value="">
                    <datalist id="listruangan">
                        <?php foreach($ruangan as $key => $value): ?>
                        <option value="<?php echo ($value->ruangan); ?>" <?php echo(inputSelect($value->ruangan, $ruangan)); ?> >
                        <?php endforeach; ?>
                    </datalist>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="berat">Posisi </label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_posisi_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_posisi"); ?></small></span>
                    <input type="text" maxlength="250" class="form-control" name="posisi" placeholder="Posisi barang" list="listposisi" autocomplete="off" value="">
                    <datalist id="listposisi">
                        <?php foreach($posisi as $key => $value): ?>
                        <option value="<?php echo ($value->posisi); ?>" <?php echo(inputSelect($value->posisi, $posisi)); ?> >
                        <?php endforeach; ?>
                    </datalist>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="form-group">
                    <label for="berat">Berat <small>(g)</small></label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_berat_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_berat"); ?></small></span>
                    <input type="number" class="form-control" autocomplete="off" name="berat" id="berat" min="0" value="" required />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label for="stok">Dalam Stok</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_stok_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_stok"); ?></small></span>
                    <input type="number" class="form-control" autocomplete="off" name="stok" id="stok" min="0" value="" required />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="form-group">
                    <label for="kadaluarsa">Kadaluarsa</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_kadaluarsa_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_kadaluarsa"); ?></small></span>
                    <input type="date" class="form-control" autocomplete="off" name="kadaluarsa" id="kadaluarsa" value="<?php echo ((date('Y') + 1) . date('-m-d')); ?>" required />
                </div>
                <div class="form-group">
                    <label for="vendor">Vendor</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_id_vendor_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_id_vendor"); ?></small></span>
                    <select name="id_vendor" id="id_vendor" class="form-control" required>
                        <?php foreach ($vendor as $key => $value) : ?>
                            <option value="<?php echo ($value->id); ?>"><?php echo ($value->nama_vendor); ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="foto">Foto Barang</label>&nbsp;<span class="<?php echo session()->getFlashdata("ci_flash_message_foto_type"); ?>"><small><?php echo session()->getFlashdata("ci_flash_message_foto"); ?></small></span>
                    <input type="file" name="foto" id="foto" accept="*" class="form-control" >
                </div>
            </div>
        </div>
    </fieldset>