<?php 
$this->extend('administrator/_templates/Container');
$this->section('content');
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-cogs"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <?php if (session()->getFlashdata('ci_flash_message')!=NULL): ?>
        <div class="alert text-center mb-1 mt-0 <?php echo session()->getFlashdata('ci_flash_message_type') ?>" role="alert">
            <small><?php echo session()->getFlashdata('ci_flash_message') ?></small>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $PageAttribute["title"]; ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="transform: rotate(0);">
                                            Nama Pengaturan
                                        </th>
                                        <th style="transform: rotate(0);">
                                            Nilai
                                        </th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                </tbody>
                                    <tr>
                                        <form action="<?php echo (base_url('administrator/Profil_perusahaan/update_action')); ?>" method="POST">
                                            <td>Nama Perusahaan</td>
                                            <input type="hidden" name="oldid" value="nama_perusahaan">
                                            <td><input type="text" class="form-control" name="v" value="<?php echo $nama_perusahaan ?>"></td>
                                            <td><button type="submit" class="btn btn-sm btn-success form-control"><?php echo (lang('Default.Button.Save', [], $PageAttribute["locale"])); ?></button></td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form action="<?php echo (base_url('administrator/Profil_perusahaan/update_action')); ?>" method="POST">
                                            <td>Telepon Perusahaan</td>
                                            <input type="hidden" name="oldid" value="telepon_perusahaan">
                                            <td><input type="text" class="form-control" name="v" value="<?php echo $telepon_perusahaan ?>"></td>
                                            <td><button type="submit" class="btn btn-sm btn-success form-control"><?php echo (lang('Default.Button.Save', [], $PageAttribute["locale"])); ?></button></td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form action="<?php echo (base_url('administrator/Profil_perusahaan/update_action')); ?>" method="POST">
                                            <td>Alamat Perusahaan</td>
                                            <input type="hidden" name="oldid" value="alamat_perusahaan">
                                            <td><input type="text" class="form-control" name="v" value="<?php echo $alamat_perusahaan ?>"></td>
                                            <td><button type="submit" class="btn btn-sm btn-success form-control"><?php echo (lang('Default.Button.Save', [], $PageAttribute["locale"])); ?></button></td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form action="<?php echo (base_url('administrator/Profil_perusahaan/update_action')); ?>" method="POST">
                                            <td>Pengingat Kadaluarsa (Hari)</td>
                                            <input type="hidden" name="oldid" value="pengingat_kadaluarsa">
                                            <td><input type="number" class="form-control" name="v" value="<?php echo $pengingat_kadaluarsa ?>"></td>
                                            <td><button type="submit" class="btn btn-sm btn-success form-control"><?php echo (lang('Default.Button.Save', [], $PageAttribute["locale"])); ?></button></td>
                                        </form>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>;