<?php
$this->extend('administrator/_templates/Container');
$this->section('content'); ?>

<!-- top tiles -->
<div class="row">
  <div class="tile_count" style="width: 100% !important;">

    <div class="col-lg-3 col-md-3 col-sm-3 tile_stats_count" style="border-bottom: 1px solid black">
      <span class="count_top"><i class="fa fa-cubes"></i> <?php echo lang('Text.TotalAssets', [], $PageAttribute['locale']) ?></span>
      <div class="count"><?php echo (formatNumber($total_barang_sekarang)); ?></div>
      <span class="count_bottom">
        <?php if ($total_barang_sekarang > $total_barang_lalu) : ?>
          <i class="green"><i class="fa fa-sort-asc"></i><?php echo ($total_barang_lalu > 0 ? round((($total_barang_sekarang - $total_barang_lalu) / $total_barang_lalu) * 100) : $total_barang_sekarang); ?>%</i>
        <?php else : ?>
          <i class="red"><i class="fa fa-sort-desc"></i><?php echo ($total_barang_lalu > 0 ? round(100 - (($total_barang_sekarang / $total_barang_lalu) * 100)) : $total_barang_sekarang); ?>%</i>
        <?php endif; ?>
        &nbsp;<?php echo lang('Text.FromLastMonth', [], $PageAttribute['locale']) ?>
      </span>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-3 tile_stats_count" style="border-bottom: 1px solid black">
      <span class="count_top"><i class="fa fa-cube"></i> <?php echo lang('Text.TotalAssetsGrouped', [], $PageAttribute['locale']) ?></span>
      <div class="count"><?php echo (formatNumber($total_jenis_sekarang)); ?></div>
      <span class="count_bottom">
        <?php if ($total_jenis_sekarang > $total_jenis_lalu) : ?>
          <i class="green"><i class="fa fa-sort-asc"></i><?php echo ($total_jenis_lalu > 0 ? round((($total_jenis_sekarang - $total_jenis_lalu) / $total_jenis_lalu) * 100) : $total_jenis_sekarang); ?>%</i>
        <?php else : ?>
          <i class="red"><i class="fa fa-sort-desc"></i><?php echo ($total_jenis_lalu > 0 ? round(100 - (($total_jenis_sekarang / $total_jenis_lalu) * 100)) : $total_jenis_sekarang); ?>%</i>
        <?php endif; ?>
        &nbsp;<?php echo lang('Text.FromLastMonth', [], $PageAttribute['locale']) ?>
      </span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 tile_stats_count" style="border-bottom: 1px solid black">
      <span class="count_top"><i class="fa fa-money"></i> <?php echo lang('Text.AssetValue', [], $PageAttribute['locale']) ?></span>
      <div class="count green">Rp <?php echo (formatNumber($total_nilai)); ?></div>
      <span class="count_bottom"><?php echo lang('Text.Accumulation', [], $PageAttribute['locale']) ?></span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 tile_stats_count" style="border-bottom: 1px solid black">
      <span class="count_top"><i class="fa fa-inbox"></i> <?php echo lang('Text.PurchaseValues', [], $PageAttribute['locale']) ?></span>
      <div class="count">Rp <?php echo (formatNumber($total_pembelian_sekarang)); ?></div>
      <span class="count_bottom">
        <?php if ($total_pembelian_sekarang > $total_pembelian_lalu) : ?>
          <i class="green"><i class="fa fa-sort-asc"></i><?php echo ($total_pembelian_lalu > 0 ? round((($total_pembelian_sekarang - $total_pembelian_lalu) / $total_pembelian_lalu) * 100) : $total_pembelian_sekarang); ?>%</i>
        <?php else : ?>
          <i class="red"><i class="fa fa-sort-desc"></i><?php echo ($total_pembelian_lalu > 0 ? round(100 - (($total_pembelian_sekarang / $total_pembelian_lalu) * 100)) : $total_pembelian_sekarang); ?>%</i>
        <?php endif; ?>
        &nbsp;<?php echo lang('Text.FromLastMonth', [], $PageAttribute['locale']) ?>
      </span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 tile_stats_count" style="border-bottom: 1px solid black">
      <span class="count_top"><i class="fa fa-tags"></i> <?php echo lang('Text.SaleValues', [], $PageAttribute['locale']) ?></span>
      <div class="count">Rp <?php echo (formatNumber($total_penjualan_sekarang)); ?></div>
      <span class="count_bottom">
        <?php if ($total_penjualan_sekarang > $total_penjualan_lalu) : ?>
          <i class="green"><i class="fa fa-sort-asc"></i><?php echo ($total_penjualan_lalu > 0 ? round((($total_penjualan_sekarang - $total_penjualan_lalu) / $total_penjualan_lalu) * 100) : $total_penjualan_sekarang); ?>%</i>
        <?php else : ?>
          <i class="red"><i class="fa fa-sort-desc"></i><?php echo ($total_penjualan_lalu > 0 ? round(100 - (($total_penjualan_sekarang / $total_penjualan_lalu) * 100)) : $total_penjualan_sekarang); ?>%</i>
        <?php endif; ?>
        &nbsp;<?php echo lang('Text.FromLastMonth', [], $PageAttribute['locale']) ?>
      </span>
    </div>

  </div>
</div>
<!-- /top tiles -->

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="dashboard_graph">

      <div class="row x_title">
        <div class="col-md-6">
          <h3><?php echo lang('Text.ChartThisYear', [], $PageAttribute['locale']) ?></h3>
        </div>
        <div class="col-md-6">
          <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
            <span>Jan 01, <?php echo (date("Y")); ?> - Dec 31, <?php echo (date("Y")); ?></span> <b class="caret"></b>
          </div>
        </div>
      </div>

      <div class="d-none hide hidden">
        <div id="graph-pembelian-fill">
          <?php foreach ($pembelian as $key => $value) : ?>
            <span><i class="tahun"><?php echo ($value->tahun); ?></i><i class="bulan"><?php echo ($value->bulan); ?></i><i class="total"><?php echo ($value->total); ?></i></span>
          <?php endforeach; ?>
        </div>
        <div id="graph-penjualan-fill">
          <?php foreach ($penjualan as $key => $value) : ?>
            <span><i class="tahun"><?php echo ($value->tahun); ?></i><i class="bulan"><?php echo ($value->bulan); ?></i><i class="total"><?php echo ($value->total); ?></i></span>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-md-9 col-sm-9 ">
        <div id="chart_plot_01" class="demo-placeholder"></div>
      </div>
      <div class="col-md-3 col-sm-3  bg-white">
        <div class="x_title">
          <h2><?php echo lang('Text.StatisticsThisMonth', [], $PageAttribute['locale']) ?></h2>
          <div class="clearfix"></div>
        </div>

        <div class="col-md-12 col-sm-12 ">
          <div>
            <p><?php echo lang('Text.Purchase', [], $PageAttribute['locale']) ?></p>
            <div class="">
              <div class="progress progress_sm">
                <div class="progress-bar" role="progressbar" data-transitiongoal="<?php echo ($pembelian_banding); ?>" style="background-color: rgba(38, 185, 154, 0.38);" data-toggle="tooltip" data-placement="top" title="<?php echo round($pembelian_banding); ?>%"></div>
              </div>
            </div>
          </div>
          <div>
            <p><?php echo lang('Text.Sale', [], $PageAttribute['locale']) ?></p>
            <div class="">
              <div class="progress progress_sm">
                <div class="progress-bar" role="progressbar" data-transitiongoal="<?php echo ($penjualan_banding); ?>" style="background-color: rgba(63, 08, 136, 0.38);" data-toggle="tooltip" data-placement="bottom" title="<?php echo round($penjualan_banding); ?>%"></div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="clearfix"></div>
    </div>
  </div>

</div>
<br />
<?php $this->endSection(); ?>