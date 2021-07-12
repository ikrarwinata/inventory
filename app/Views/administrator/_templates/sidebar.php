		<div class="col-md-3 left_col">
			<div class="left_col scroll-view">
				<div class="navbar nav_title" style="border: 0;">
					<a href="administrator/Dashboard" class="site_title"><i class="fa fa-barcode"></i> <span><?php echo wordwrap(session("nama_perusahaan"), 20, "...", TRUE); ?></span></a>
				</div>

				<div class="clearfix"></div>

				<!-- menu profile quick info -->
				<div class="profile clearfix">
					<div class="profile_pic">
						<img src="assets/images/img.jpg" alt="..." class="img-circle profile_img">
					</div>
					<div class="profile_info">
						<span><?php echo lang('Text.Welcome', [], $PageAttribute['locale']) ?>,</span>
						<h2><?php echo session("nama") ?></h2>
					</div>
				</div>
				<!-- /menu profile quick info -->

				<br />

				<!-- sidebar menu -->
				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
					<div class="menu_section">
						<ul class="nav side-menu">
							<li><a href="<?php echo base_url('administrator/Dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('Text.Dashboard', [], $PageAttribute['locale']) ?></a></li>
						</ul>
					</div>

					<div class="menu_section">
						<h3> <?php echo lang('Text.Transaction', [], $PageAttribute['locale']) ?></h3>
						<ul class="nav side-menu">
							<li><a><i class="fa fa-cube"></i> <?php echo lang('Text.Assets', [], $PageAttribute['locale']) ?> <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu">
									<li><a href="<?php echo (base_url('administrator/Pembelian/create')); ?>"> <?php echo lang('Text.Purchase', [], $PageAttribute['locale']) ?></a></li>
									<li><a href="<?php echo (base_url('administrator/Penjualan/create')); ?>"> <?php echo lang('Text.Sale', [], $PageAttribute['locale']) ?></a></li>
									<li><a href="<?php echo (base_url('administrator/Penjualan/batch')); ?>"> <?php echo lang('Text.SaleBatch', [], $PageAttribute['locale']) ?></a></li>
									<li><a href="<?php echo (base_url('administrator/Pengembalian/create')); ?>"> <?php echo lang('Text.Return', [], $PageAttribute['locale']) ?></a></li>
								</ul>
							</li>
							<li><a><i class="fa fa-clone"></i> <?php echo lang('Text.Vendor', [], $PageAttribute['locale']) ?> <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu">
									<li><a href="<?php echo (base_url('administrator/Vendor/create')); ?>"> <?php echo lang('Text.AddVendor', [], $PageAttribute['locale']) ?></a></li>
								</ul>
							</li>
							<li><a><i class="fa fa-clone"></i> <?php echo lang('Text.Divisi', [], $PageAttribute['locale']) ?> <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu">
									<li><a href="<?php echo (base_url('administrator/Divisi/create')); ?>"> <?php echo lang('Text.AddDivisi', [], $PageAttribute['locale']) ?></a></li>
								</ul>
							</li>
						</ul>
					</div>

					<div class="menu_section">
						<h3> <?php echo lang('Text.Operation', [], $PageAttribute['locale']) ?></h3>
						<ul class="nav side-menu">
							<li><a href="<?php echo base_url('administrator/Operation/pricing') ?>"><i class="fa fa-sitemap"></i> <?php echo lang('Text.Pricing', [], $PageAttribute['locale']) ?></a></li>
							<li><a href="<?php echo base_url('administrator/Operation/truncate') ?>"><i class="fa fa-trash"></i> <?php echo lang('Text.Truncate', [], $PageAttribute['locale']) ?></a></li>
							<li><a href="<?php echo base_url('administrator/Operation/kadaluarsa') ?>">
									<i class="fa fa-calendar"></i> <?php echo lang('Text.Expire', [], $PageAttribute['locale']) ?>
									<?php if (session("barang_kadaluarsa") > 0) : ?>
										<span class="badge badge-warning"><?php echo (session("barang_kadaluarsa")); ?> Items</span>
									<?php endif; ?>
								</a></li>
							<li><a href="<?php echo base_url('administrator/Operation/barcode') ?>"><i class="fa fa-barcode"></i> <?php echo lang('Text.Barcode', [], $PageAttribute['locale']) ?></a></li>
						</ul>
					</div>

					<div class="menu_section">
						<h3> <?php echo lang('Text.Data', [], $PageAttribute['locale']) ?></h3>
						<ul class="nav side-menu">

							<li><a><i class="fa fa-cubes"></i> <?php echo lang('Text.Assets', [], $PageAttribute['locale']) ?> <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu">
									<li><a href="<?php echo (base_url('administrator/Master/index')) ?>"><i class="fa fa-cubes"></i> <?php echo lang('Text.DataAssets', [], $PageAttribute['locale']) ?></a></li>
									<li><a href="<?php echo (base_url('administrator/Master/history')) ?>"><i class="fa fa-list"></i> <?php echo lang('Text.DataAssetsHistory', [], $PageAttribute['locale']) ?></a></li>
									<li><a href="<?php echo (base_url('administrator/Kategori_master/index')); ?>"><i class="fa fa-glass"></i> <?php echo lang('Text.Category', [], $PageAttribute['locale']) ?></a></li>
									<li><a href="<?php echo (base_url('administrator/Satuan_master/index')); ?>"><i class="fa fa-tachometer"></i> <?php echo lang('Text.Units', [], $PageAttribute['locale']) ?></a></li>
								</ul>
							</li>

							<li><a href="<?php echo (base_url('administrator/Pembelian/index')); ?>"><i class="fa fa-inbox"></i> <?php echo lang('Text.DataPurchase', [], $PageAttribute['locale']) ?></a></li>
														
							<li><a><i class="fa fa-cubes"></i> <?php echo lang('Text.DataSale', [], $PageAttribute['locale']) ?> <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu">
									<li><a href="<?php echo (base_url('administrator/Penjualan/index')) ?>"><i class="fa fa-tags"></i> <?php echo lang('Text.DataSale', [], $PageAttribute['locale']) ?></a></li>
									<li><a href="<?php echo (base_url('administrator/Invoice/index')) ?>"><i class="fa fa-list"></i> Invoice</a></li>
								</ul>
							</li>

							<li><a href="<?php echo (base_url('administrator/Pengembalian/index')); ?>"><i class="fa fa-reply"></i> <?php echo lang('Text.Return', [], $PageAttribute['locale']) ?></a></li>

							<li><a href="<?php echo (base_url('administrator/Vendor/index')); ?>"><i class="fa fa-clone"></i> <?php echo lang('Text.Vendor', [], $PageAttribute['locale']) ?></a></li>
							<li><a href="<?php echo (base_url('administrator/Divisi/index')); ?>"><i class="fa fa-clone"></i> <?php echo lang('Text.Divisi', [], $PageAttribute['locale']) ?></a></li>
							<?php if (session("level") == "superadmin") : ?>
								<li><a href="<?php echo base_url('administrator/Users/index') ?>"><i class="fa fa-users"></i> <?php echo lang('Text.Users', [], $PageAttribute['locale']) ?></a></li>
							<?php endif ?>
						</ul>
					</div>

				</div>
				<!-- /sidebar menu -->

				<!-- /menu footer buttons -->
				<div class="sidebar-footer hidden-small">
					<a data-toggle="tooltip" data-placement="top" title="<?php echo lang('Default.Button.Profile', [], $PageAttribute['locale']) ?>" href="<?php echo (base_url('administrator/Users/update/' . session('username'))); ?>">
						<span class="fa fa-user" aria-hidden="true"></span>
					</a>
					<?php if (session("level") == "superadmin") : ?>
						<a data-toggle="tooltip" data-placement="top" title="<?php echo lang('Text.Settings', [], $PageAttribute['locale']) ?>" href="<?php echo (base_url('administrator/Profil_perusahaan/index')); ?>">
							<span class="fa fa-cogs" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="<?php echo lang('Text.Users', [], $PageAttribute['locale']) ?>" href="<?php echo base_url('administrator/Users/index') ?>">
							<span class="fa fa-users" aria-hidden="true"></span>
						</a>
					<?php endif; ?>
					<a data-toggle="tooltip" data-placement="top" title="<?php echo lang('Default.Button.Logout', [], $PageAttribute['locale']) ?>" href="<?php echo base_url('Home/logout') ?>">
						<span class="fa fa-sign-out" aria-hidden="true"></span>
					</a>
				</div>
				<!-- /menu footer buttons -->
			</div>
		</div>