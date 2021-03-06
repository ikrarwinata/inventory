   <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <title><?php echo wordwrap(session("nama_perusahaan"), 100, "...", TRUE) . " :: " . $PageAttribute['title'] ?></title>
     <base href="<?php echo (base_url()) ?>">

     <!-- Bootstrap -->
     <link href="assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Font Awesome -->
     <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
     <!-- NProgress -->
     <link href="assets/vendors/nprogress/nprogress.css" rel="stylesheet">
     <!-- iCheck -->
     <link href="assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

     <!-- bootstrap-progressbar -->
     <link href="assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
     <!-- JQVMap -->
     <link href="assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
     <!-- bootstrap-daterangepicker -->
     <link href="assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

     <!-- Custom Theme Style -->
     <link href="assets/build/css/custom.min.css" rel="stylesheet">

     <?php foreach ($PageAttribute["stylesheets"] as $key => $stylesheet) : ?>
       <link rel="stylesheet" href="<?php echo $stylesheet ?>">
     <?php endforeach ?>
   </head>