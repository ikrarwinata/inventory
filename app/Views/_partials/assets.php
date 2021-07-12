    <fieldset style="border: 1px solid rgba(6,139,168,0.67); padding: 8px; margin: 8px;">
        <div class="form-group">
            <label for="id_master">Kode Barang</label>
            <input type="text" class="form-control" autocomplete="off" maxlength="100" value="<?php echo ($data->id); ?>" disabled />
            <input type="hidden" autocomplete="off" name="id_master" id="id_master" value="<?php echo ($data->id); ?>" />
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" class="form-control" autocomplete="off" name="kategori" id="kategori" value="<?php echo ($data->nama_kategori); ?>" disabled />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label for="berat">Berat (g)</label>
                    <input type="text" class="form-control" autocomplete="off" name="berat" id="berat" value="<?php echo ($data->berat); ?> G" disabled />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label for="stok">Dalam Stok</label>
                    <input type="text" class="form-control" autocomplete="off" value="<?php echo ($data->stok . ' ' . $data->nama_satuan); ?>" disabled />
                    <input type="hidden" autocomplete="off" name="stok" id="stok" value="<?php echo ($data->stok); ?>" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-group">
                    <label for="harga">Harga <small>(Rp)</small></label>
                    <input type="text" class="form-control" autocomplete="off" name="harga" id="harga" value="<?php echo (formatNumber($data->harga)); ?>" disabled />
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="form-group">
                    <label for="posisi">Lokasi Barang</label>
                    <?php 
                    $posisi = isset($data->gedung)?$data->gedung:NULL;
                    $posisi .= isset($data->ruangan)?", " . $data->ruangan:NULL;
                    $posisi .= isset($data->posisi)?", " . $data->posisi:NULL;
                    ?>
                    <input type="text" class="form-control" autocomplete="off" value="<?php echo ($posisi); ?>" disabled />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="form-group">
                    <label for="vendor">Vendor</label>
                    <input type="text" class="form-control" autocomplete="off" name="vendor" id="vendor" value="<?php echo ($data->nama_vendor); ?>" disabled />
                </div>
                <div class="form-group">
                    <label for="kadaluarsa">Kadaluarsa</label>
                    <input type="date" class="form-control" autocomplete="off" name="kadaluarsa" id="kadaluarsa" value="<?php echo (date('Y-m-d', $data->kadaluarsa)); ?>" required />
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <a href="<?php echo base_url($data->foto); ?>" target="_blank"><img src="<?php echo base_url($data->foto); ?>" alt="" style="max-height:150px; max-width:280px;"></a>
            </div>
        </div>
        
    </fieldset>