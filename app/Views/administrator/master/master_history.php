<?php
$this->extend('administrator/_templates/Container');
$this->section('content');
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-inbox"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 mb-3">
            <?php echo form_open_multipart(base_url($PageAttribute['parent'] . '/from_excel'), 'class="form-inline"'); ?>
            <div class="dropdown">
                <button class="btn btn-sm btn-info dropdown-toggle ml-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Export
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <!--EXPORTTOEXCEL-->
                    <a class="dropdown-item" href="<?php echo base_url($PageAttribute['parent'] . '/history_excel') ?>" target="_blank">Export Excel</a>
                    <!--ENDEXPORTTOEXCEL-->
                    <!--EXPORTTOWORD-->
                    <a class="dropdown-item" href="<?php echo base_url($PageAttribute['parent'] . '/history_word') ?>" target="_blank">Export Word</a>
                    <!--ENDEXPORTTOWORD-->
                    <!--PRINTALL-->
                    <a class="dropdown-item" href="<?php echo base_url($PageAttribute['parent'] . '/history_print_all') ?>" target="_blank">Print All</a>
                    <!--ENDPRINTALL-->
                </div>
            </div>
            </form>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <form action="<?php echo base_url($PageAttribute['parent'] . '/history') ?>" class="form-inline" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" value="<?php echo $keyword; ?>">
                    <span class="input-group-btn">
                        <?php
                        if ($keyword <> '') {
                        ?>
                            <a href="<?php echo base_url($PageAttribute['parent'] . '/history') ?>" class="btn btn-default"><?php echo lang('Default.Button.ResetSearch', [], $PageAttribute['locale']) ?></a>
                        <?php
                        }
                        ?>
                        <button class="btn btn-primary" type="submit"><?php echo lang('Default.Button.SearchData', [], $PageAttribute['locale']) ?></button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <form action="<?php echo base_url($PageAttribute['parent'] . '/history') ?>" class="form-inline" method="post">
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
                    <h2><?php echo lang('Text.Data', [], $PageAttribute['locale']) ?> <?php echo $PageAttribute["title"]; ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="<?php echo (site_url($PageAttribute['parent'] . '/delete_batch')) ?>" method="post">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="60px" class="text-center">#</th>
                                            <th class="align-middle" width="40px"><i class="fa fa-fa-chevron-circle-down"></i></th>
                                            <th>
                                                ID Transaksi
                                            </th>
                                            <th>
                                                Kode Barang
                                            </th>
                                            <th class="text-center">
                                                Quantity
                                            </th>
                                            <th class="text-center">
                                                Nilai Satuan
                                            </th>
                                            <th style="transform: rotate(0);">
                                                <a href="<?php echo base_url($PageAttribute['parent'] . '/history?sortcolumn=' . base64_encode('master_history.timestamps') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                    <?php if ($sortcolumn == "master_history.timestamps") : ?>
                                                        <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                        <?php endif ?>Tanggal
                                                </a>
                                            </th>
                                            <th>
                                                Vendor/Divisi
                                            </th>
                                            <th>
                                                Username
                                            </th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    <?php
                                    $counter = $start;
                                    $total = 0;
                                    $subtotal = 0;
                                    foreach ($data as $value) :
                                        $subtotal = $value->harga * $value->quantity;
                                        $total += $subtotal;
                                        $badge = 'badge-success';
                                        if ($value->Riwayat == 'Pengeluaran'){
                                            $badge = 'badge-danger';
                                        }elseif ($value->Riwayat == 'Pengembalian'){
                                            $badge = 'badge-warning';
                                        }else{
                                            $badge = 'badge-success';
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $counter++ ?></td>
                                            <td class="align-middle"><a href="#" data-toggle="<?php echo ($value->id); ?>" class="toggle-detail"><i class="fa fa-chevron-down fa-lg"></i></a></td>
                                            <td><?php echo $value->id ?></td>
                                            <td><a href="<?php echo (base_url('administrator/Master/read/' . $value->id_master)) ?>"><?php echo $value->id_master ?></a></td>
                                            <td class="text-center"><span class="badge <?php echo ($badge); ?>"><?php echo $value->operators . formatNUmber($value->quantity) ?></span></td>
                                            <td class="text-center">Rp <?php echo formatNumber($value->harga) ?></td>
                                            <td><?php echo date("d-m-Y", $value->timestamps) ?></td>
                                            <td><a href="<?php echo (base_url('administrator/Vendor/read/' . $value->id_suplier)) ?>"><?php echo ($value->id_suplier) ?></a></td>
                                            <td><a href="<?php echo (base_url('administrator/Users/read/' . $value->username)) ?>"><?php echo $value->username ?></a></td>
                                            <td>
                                                Rp <?php echo (formatNumber($subtotal)); ?>
                                            </td>
                                        </tr>
                                        <tr class="d-none" id="<?php echo ($value->id); ?>">
                                            <td colspan="11">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <h5 class="<?php echo ($value->Riwayat == "Beli" ? "text-success" : "text-danger"); ?>"><?php echo ($value->Riwayat); ?></h5>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
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
                                                                Stok Sekarang
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
                                    <tfoot>
                                        <tr>
                                            <th colspan="9" class="text-center">Total</th>
                                            <th>Rp <?php echo (formatNumber($total)); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-sm btn-outline-warning ml-2 mt-2 mb-2" title="<?php echo lang("Default.Tooltips.DeleteSelected", [], $PageAttribute["locale"]) ?>" onclick="return confirm('<?php echo lang("Promp.DeleteSelected", [], $PageAttribute["locale"]) ?>')">
                                <i class="fa fa-minus-square"></i>&nbsp;<?php echo lang("Default.Button.DeleteSelected", [], $PageAttribute["locale"]) ?>
                            </button>
                            <a href="<?php echo site_url($PageAttribute['parent'] . '/truncate') ?>" class="btn btn-sm btn-outline-danger ml-2 mt-2 mb-2" onclick="return confirm('<?php echo lang("Promp.Truncate", [], $PageAttribute["locale"]) ?>')">
                                <i class="fa fa-trash"></i>&nbsp;<?php echo lang("Default.Button.Truncate", [], $PageAttribute["locale"]) ?>
                            </a>
                        </div>
                    </form>
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