<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Inventory | Login</title>
    <base href="<?php echo base_url() ?>">
    <!-- Bootstrap -->
    <link href="assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <link href="assets/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="assets/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?php echo base_url('Home/login_auth') ?>" method="POST">
              <h1>Login Administrator</h1>
              <div>
                <div class="card">
                  
                </div>
              </div>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Username" required="true" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="true" />
              </div>
              <div>
                <input type="checkbox" checked="true" name="keepalive" id="keepalive" class="" value="1" />
                <label for="keepalive"><?php echo lang('Default.Button.RememberLogin', [], $PageAttribute['locale']) ?></label>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <a class="btn btn-default submit" href=""><?php echo lang('Default.Button.ForgotPassword', [], $PageAttribute['locale']) ?></a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 text-center">
                  <button type="submit" class="form-control btn btn btn-default btn-sm d-xl-none d-lg-none d-md-none d-sm-none d-xs-block"><?php echo lang('Default.Button.Login', [], $PageAttribute['locale']) ?></button>
                  <button type="submit" class="reset_pass btn btn btn-default btn-sm d-xl-block d-lg-block d-md-block d-sm-block d-xs-none d-none"><?php echo lang('Default.Button.Login', [], $PageAttribute['locale']) ?></button>
                </div>
                
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-barcode"></i>&nbsp;Sistem Inventory</h1>
                  <p>©<?php echo date("Y") ?> All Rights Reserved. Sistem Inventory. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <script src="assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/pnotify/dist/pnotify.js"></script>
    <script src="assets/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="assets/vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <?php if (session()->getFlashdata('ci_flash_message')!=NULL): ?>
      <script type="text/javascript">
        jQuery(function($) {
          new PNotify({
              title: ' Uppsss...',
              type: "<?php echo session()->getFlashdata('ci_flash_message_type') ?>",
              text: "<?php echo session()->getFlashdata('ci_flash_message') ?>",
              nonblock: {
                  nonblock: true
              },
              styling: 'bootstrap3',
          });
        })
      </script>
    <?php endif ?>
  </body>
</html>
