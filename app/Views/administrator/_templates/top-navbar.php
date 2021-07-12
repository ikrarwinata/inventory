        <div class="top_nav">
          <div class="nav_menu">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/img.jpg" alt=""><?php echo session("nama") ?>
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo (base_url('administrator/Users/update/' . session('username'))); ?>"> <?php echo lang('Default.Button.Profile', [], $PageAttribute['locale']) ?></a>
                    <?php if (session("level") == "superadmin") : ?>
                      <a class="dropdown-item" href="<?php echo (base_url('administrator/Profil_perusahaan/index')); ?>">Settings</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="<?php echo base_url('Home/logout') ?>"><i class="fa fa-sign-out pull-right"></i> <?php echo lang('Default.Button.Logout', [], $PageAttribute['locale']) ?></a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-globe"></i>
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">

                    <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item" href="<?php echo base_url('id/Home?redirect=' . base64_encode($PageAttribute['parent'] . '/index')) ?>">
                          <span class="image"><i class="fa fa-globe-americas"></i></span>
                          <?php if ($PageAttribute["locale"] == "id") : ?>
                            <strong>Indonesia</strong>
                          <?php else : ?>
                            Indonesia
                          <?php endif ?>
                        </a>
                      </div>
                    </li>
                    <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item" href="<?php echo base_url('en/Home?redirect=' . base64_encode($PageAttribute['parent'] . '/index')) ?>">
                          <span class="image"><i class="fa fa-globe-asia"></i></span>
                          <?php if ($PageAttribute["locale"] == "en") : ?>
                            <strong>English</strong>
                          <?php else : ?>
                            English
                          <?php endif ?>
                        </a>
                      </div>
                    </li>

                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>