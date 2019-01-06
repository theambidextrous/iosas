<?php
session_start();
 $err = [];
 $succ = [];
require_once("../iosys/inf.ionf.conf.php");
//get user permissions
$user_data = getCurrentUserDetails($_SESSION['USRID']);
$user_permissions = getCurrentUserPermissions(getUserType($_SESSION['USRID']))['access'];
$school_name = getSchoolName($user_data['school_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?=$school_name?></title>
  <link rel="stylesheet" href="<?=SYS_PATH?>public/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?=SYS_PATH?>public/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?=SYS_PATH?>public/css/style.css">
  <link rel="shortcut icon" href="<?=SYS_PATH?>public/images/favicon.png" />
  <style>
    #icon-flipped {
      -moz-transform: scaleX(-1);
      -o-transform: scaleX(-1);
      -webkit-transform: scaleX(-1);
      transform: scaleX(-1);
      filter: FlipH;
      -ms-filter: "FlipH";
}
  </style>
</head>
<body>
  <div class="container-scroller">
    <!-- Top dashboard nav -->
    <?php include '../commons/top-dashboard-nav.php'; ?>
    <!-- end top dashboard nav -->
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
     <?php include '../commons/side-nav.php';?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12">
              <span class="d-flex align-items-center purchase-popup">
                <h1><b>Welcome to <?=$school_name?></b></h1>
              </span>
            </div>
          </div>
          <!-- start pages -->
          <?php 
          // echo '<pre>';
          // print_r(getUserGroup(4444,3));
          // echo '</pre>';
          $to = !empty($_REQUEST['to'])?$_REQUEST['to']:'Dashboard';
          switch($to){
            case 'Dashboard':
            require_once('Dashboard.php');
            break;
          }
          ?>
          <!-- end pages -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
       <?php include '../commons/footer.php'; ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="<?=SYS_PATH?>public/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?=SYS_PATH?>public/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?=SYS_PATH?>public/js/off-canvas.js"></script>
  <script src="<?=SYS_PATH?>public/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?=SYS_PATH?>public/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>
</html>
