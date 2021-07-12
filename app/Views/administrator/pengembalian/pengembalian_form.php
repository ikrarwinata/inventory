<?php
$this->extend('administrator/_templates/Container');
$this->section('content');
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-tags"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 mb-3">
            <form action="<?php echo base_url($PageAttribute['parent'] . '/index') ?>" class="form-inline" method="post">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text form-control">
                            <?php echo lang('Default.perPage', [], $PageAttribute['locale']) ?>
                        </div>
                    </div>
                    <input type="number" class="form-control" min="2" max="9999999999" name="perPage" value="<?php echo $perPage ?>">
                    <button class="btn btn-secondary" type="submit"><?php echo lang('Default.Button.Show', [], $PageAttribute['locale']) ?></button>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <form action="<?php echo base_url($PageAttribute['parent'] . '/create') ?>" class="form-inline" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" value="<?php echo $keyword; ?>">
                    <span class="input-group-btn">
                        <?php
                        if ($keyword <> '') {
                        ?>
                            <a href="<?php echo base_url($PageAttribute['parent'] . '/create') ?>" class="btn btn-default"><?php echo lang('Default.Button.ResetSearch', [], $PageAttribute['locale']) ?></a>
                        <?php
                        }
                        ?>
                        <button class="btn btn-primary" type="submit"><?php echo lang('Default.Button.SearchData', [], $PageAttribute['locale']) ?></button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <?php if (session()->getFlashdata('ci_flash_message') != NULL) : ?>
        <div class="alert text-center mb-1 mt-0 <?php echo session()->getFlashdata('ci_flash_message_type') ?>" role="alert">
            <small><?php echo session()->getFlashdata('ci_flash_message') ?></small>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pilih Transaksi Untuk Dikembalikan</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="60px" class="text-center">#</th>
                                        <th class="align-middle" width="40px"><i class="fa fa-fa-chevron-circle-down"></i></th>
                                        <th style="transform: rotate(0);">
                                            <a href="<?php echo base_url($PageAttribute['parent'] . '/create?sortcolumn=' . base64_encode('id') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                <?php if ($sortcolumn == "id") : ?>
                                                    <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                    <?php endif ?>ID Transaksi
                                            </a>
                                        </th>
                                        <th style="transform: rotate(0);">
                                            <a href="<?php echo base_url($PageAttribute['parent'] . '/create?sortcolumn=' . base64_encode('id_master') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                <?php if ($sortcolumn == "id_master") : ?>
                                                    <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                    <?php endif ?>Kode Barang
                                            </a>
                                        </th>
                                        <th style="transform: rotate(0);" class="text-center">
                                            <a href="<?php echo base_url($PageAttribute['parent'] . '/create?sortcolumn=' . base64_encode('quantity') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                <?php if ($sortcolumn == "quantity") : ?>
                                                    <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                    <?php endif ?>Quantity
                                            </a>
                                        </th>
                                        <th style="transform: rotate(0);" class="text-center">
                                            <a href="<?php echo base_url($PageAttribute['parent'] . '/create?sortcolumn=' . base64_encode('harga') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                <?php if ($sortcolumn == "harga") : ?>
                                                    <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                    <?php endif ?>Harga
                                            </a>
                                        </th>
                                        <th style="transform: rotate(0);">
                                            <a href="<?php echo base_url($PageAttribute['parent'] . '/create?sortcolumn=' . base64_encode('timestamps') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                <?php if ($sortcolumn == "timestamps") : ?>
                                                    <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                    <?php endif ?>Tanggal
                                            </a>
                                        </th>
                                        <th style="transform: rotate(0);">
                                            <a href="<?php echo base_url($PageAttribute['parent'] . '/create?sortcolumn=' . base64_encode('id_divisi') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                <?php if ($sortcolumn == "id_divisi") : ?>
                                                    <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                    <?php endif ?>Divisi
                                            </a>
                                        </th>
                                        <th style="transform: rotate(0);">
                                            <a href="<?php echo base_url($PageAttribute['parent'] . '/create?sortcolumn=' . base64_encode('username') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                <?php if ($sortcolumn == "username") : ?>
                                                    <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                    <?php endif ?>Username
                                            </a>
                                        </th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                </tbody>
                                <?php
                                $counter = $start;
                                foreach ($data as $value) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $counter++ ?></td>
                                        <th class="align-middle"><a href="#" data-toggle="<?php echo ($value->id); ?>" class="toggle-detail"><i class="fa fa-chevron-down fa-lg"></i></a><span class="d-none nama-placeholder"><?php echo ($value->nama); ?></span></th>
                                        <td><span class="id-placeholder"><?php echo $value->id ?></span></td>
                                        <td><a href="<?php echo (base_url('administrator/Master/read/' . $value->id_master)) ?>"><?php echo $value->id_master ?></a></td>
                                        <td class="text-center"><span class="qty-placeholder"><?php echo $value->quantity ?></span></td>
                                        <td class="text-center">Rp <?php echo formatNumber($value->harga) ?></td>
                                        <td><?php echo date("d-m-Y", $value->timestamps) ?></td>
                                        <td><a href="<?php echo (base_url('administrator/Divisi/read/' . $value->id_divisi)) ?>"><?php echo ($value->divisi) ?></a></td>
                                        <td><?php echo $value->username ?></td>
                                        <td>
                                            <span class="float-right">
                                                <?php if($value->quantity >= 1): ?>
                                                    <a type="button" class="btn btn-sm btn-success return-btn" href="#" title="<?php echo (lang('Text.Return', [], $PageAttribute["locale"])) ?>"><i class="fa fa-reply fa-lg"></i></a>
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="d-none" id="<?php echo ($value->id); ?>">
                                        <td colspan="11">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            Kode Item
                                                        </div>
                                                        <div class="col-8">
                                                            : <a href="<?php echo (base_url('administrator/Master/read/' . $value->id_master)) ?>"><?php echo $value->id_master ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-4">
                                                            Nama Item
                                                        </div>
                                                        <div class="col-8">
                                                            : <?php echo $value->nama ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-4">
                                                            Kadaluarsa
                                                        </div>
                                                        <div class="col-8">
                                                            : <?php echo date("d-m-Y", $value->kadaluarsa) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-4">
                                                            Vendor Asal
                                                        </div>
                                                        <div class="col-8">
                                                            : <a href="<?php echo (base_url('administrator/Vendor/read/' . $value->id_vendor)) ?>"><?php echo ($value->nama_vendor) ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            Dalam Stok
                                                        </div>
                                                        <div class="col-8">
                                                            : <?php echo $value->stok . " " . $value->nama_satuan ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-4">
                                                            Kategori
                                                        </div>
                                                        <div class="col-8">
                                                            : <a href="<?php echo (base_url('administrator/Master/index?keyword=' . $value->nama_kategori)) ?>"><?php echo $value->nama_kategori ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-4">
                                                            Berat Satuan
                                                        </div>
                                                        <div class="col-8">
                                                            : <?php echo ($value->berat >= 1000 ? formatNumber($value->berat / 1000) . " Kg" : formatNumber($value->berat) . " G") ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-4">
                                                            Lokasi Barang
                                                        </div>
                                                        <div class="col-8">
                                                            <?php 
                                                            $posisi = isset($value->gedung)?$value->gedung:NULL;
                                                            $posisi .= isset($value->ruangan)?", " . $value->ruangan:NULL;
                                                            $posisi .= isset($value->posisi)?", " . $value->posisi:NULL;
                                                            ?>
                                                                : <?php echo ($posisi); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="x_footer">
                    <div class="row">
                        <!-- pagination -->
                        <?php echo $pager->makeLinks($currentPage, $perPage, $totalrecord, 'custom_pagination') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>;