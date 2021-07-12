<!doctype html>
<html lang="id">
  <?php echo view('administrator/_templates/header'); ?>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php echo view('administrator/_templates/sidebar'); ?>

        <!-- top navigation -->
        <?php echo view('administrator/_templates/top-navbar'); ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
        <?php $this->renderSection('content') ?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php echo view('administrator/_templates/footer'); ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="assets/vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="assets/vendors/iCheck/icheck.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="assets/build/js/custom.js"></script>
    <?php foreach ($PageAttribute["scripts"] as $key => $script): ?>
      <script src="<?php echo $script ?>"></script>
    <?php endforeach ?>
  </body>
</html>