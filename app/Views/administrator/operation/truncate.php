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
                    <h2><?php echo lang('Text.TruncateData', [], $PageAttribute['locale']) ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <div class="field item">
                        <div class="col-form-label col-md-4 col-sm-4 label-align">
                            <a href="<?php echo (base_url('administrator/Operation/truncate_action/pembelian')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncatePurchase', [], $PageAttribute['locale']) ?></a>
                        </div>
                        <div class="col-md-8 col-sm-8 align-self-center text-danger">
                            Hapus semua data pembelian.
                        </div>
                    </div>
                    <hr>
                    <div class="field item">
                        <div class="col-form-label col-md-4 col-sm-4 label-align">
                            <a href="<?php echo (base_url('administrator/Operation/truncate_action/penjualan')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncateSales', [], $PageAttribute['locale']) ?></a>
                        </div>
                        <div class="col-md-8 col-sm-8 align-self-center text-danger">
                            Hapus semua data pengeluaran.
                        </div>
                    </div>
                    <hr>
                    <div class="field item">
                        <div class="col-form-label col-md-4 col-sm-4 label-align">
                            <a href="<?php echo (base_url('administrator/Operation/truncate_action/pengembalian')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncateReturn', [], $PageAttribute['locale']) ?></a>
                        </div>
                        <div class="col-md-8 col-sm-8 align-self-center text-danger">
                            Hapus semua data pengembalian.
                        </div>
                    </div>
                    <hr>
                    <div class="field item">
                        <div class="col-form-label col-md-4 col-sm-4 label-align">
                            <a href="<?php echo (base_url('administrator/Operation/truncate_action/kategori')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncateCategory', [], $PageAttribute['locale']) ?></a>
                        </div>
                        <div class="col-md-8 col-sm-8 align-self-center text-danger">
                            Hapus semua data Kategori. <em><strong>Tindakan ini juga menghapus data <strong>Stok Barang</strong> &amp; <strong>Data Pembelian</strong> &amp; <strong>Data Penjualan</strong> yang bersangkutan.</strong></em>
                        </div>
                    </div>
                    <hr>
                    <div class="field item">
                        <div class="col-form-label col-md-4 col-sm-4 label-align">
                            <a href="<?php echo (base_url('administrator/Operation/truncate_action/satuan')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncateUnits', [], $PageAttribute['locale']) ?></a>
                        </div>
                        <div class="col-md-8 col-sm-8 align-self-center text-danger">
                            Hapus semua data Satuan. <em><strong>Tindakan ini juga menghapus data <strong>Stok Barang</strong> &amp; <strong>Data Pembelian</strong> &amp; <strong>Data Penjualan</strong> yang bersangkutan.</strong></em>
                        </div>
                    </div>
                    <hr>
                    <div class="field item">
                        <div class="col-form-label col-md-4 col-sm-4 label-align">
                            <a href="<?php echo (base_url('administrator/Operation/truncate_action/master')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncateAssets', [], $PageAttribute['locale']) ?></a>
                        </div>
                        <div class="col-md-8 col-sm-8 align-self-center text-danger">
                            Hapus semua stok barang. <em><strong>Tindakan ini juga menghapus data <strong>Data Pembelian</strong> &amp; <strong>Data Penjualan</strong> yang bersangkutan.</strong></em>
                        </div>
                    </div>
                    <hr>
                    <div class="field item">
                        <div class="col-form-label col-md-4 col-sm-4 label-align">
                            <a href="<?php echo (base_url('administrator/Operation/truncate_action/vendor')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncateVendor', [], $PageAttribute['locale']) ?></a>
                        </div>
                        <div class="col-md-8 col-sm-8 align-self-center text-danger">
                            Hapus semua data vendor / suplier. <em><strong>Tindakan ini juga menghapus data <strong>Stok Barang</strong> &amp; <strong>Data Pembelian</strong> &amp; <strong>Data Penjualan</strong> yang bersangkutan.</strong></em>
                        </div>
                    </div>
                    <hr>
                    <div class="field item">
                        <div class="col-form-label col-md-4 col-sm-4 label-align">
                            <a href="<?php echo (base_url('administrator/Operation/truncate_action/divisi')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncateDivisi', [], $PageAttribute['locale']) ?></a>
                        </div>
                        <div class="col-md-8 col-sm-8 align-self-center text-danger">
                            Hapus semua data divisi. <em><strong>Tindakan ini juga menghapus data <strong>Data Penjualan</strong> &amp; <strong>Data Pengembalian</strong> yang bersangkutan.</strong></em>
                        </div>
                    </div>
                    <?php if (session("level") == "superadmin") : ?>
                        <hr>
                        <div class="field item">
                            <div class="col-form-label col-md-4 col-sm-4 label-align">
                                <a href="<?php echo (base_url('administrator/Operation/truncate_action/users')); ?>" class="btn btn-sm btn-outline-warning form-control text-danger" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')"><i class="fa fa-trash fa-2x text-danger"></i>&nbsp;<?php echo lang('Default.Button.TruncateUsers', [], $PageAttribute['locale']) ?></a>
                            </div>
                            <div class="col-md-8 col-sm-8 align-self-center text-danger">
                                Hapus semua data akun pengguna (terkecuali akun yang digunakan saat ini). <em><strong>Tindakan ini juga menghapus data <strong>Data Pembelian</strong> &amp; <strong>Data Penjualan</strong> yang bersangkutan.</strong></em>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>;