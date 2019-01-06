<?php
 $err = [];
 $succ = [];
require_once("iosys/inf.ionf.conf.php");
//form
if(isset($_POST['logg'])){
  $username = secure($_POST['username']);
  $password = secure($_POST['password']);
  $school = secure($_POST['school']);
  if( empty($username) || empty($password) || empty($school) || $school == 'N' ){
    array_push($err, 'Empty field detected, please correct');
  }else{
   //username,email,pasword,school
  //$password = hashPassword($password);
  $response = authenticate_user($username, $password, $school);
  if(!hasPdoErr($response)){
    if($response == 0){
      array_push($err, 'Error... Account either not found or is inactive, contact your administrator for details');
    }else{
      session_start();
    }
  }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?=SYS_SITE?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?=SYS_PATH?>public/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?=SYS_PATH?>public/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?=SYS_PATH?>public/css/style.css">
  <link rel="shortcut icon" href="<?=SYS_PATH?>public/images/favicon.png" />
  <style>
  .content-wrapper {
    background: #682475;
    padding: 2.75rem 2.25rem;
    width: 100%;
    -webkit-flex-grow: 1;
    flex-grow: 1;
}
.p-5 {
    padding: 0.9rem !important;
}
.auth form .form-group {
    margin-bottom: 0.5rem !important;
}
  </style>
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo" style="text-align:center;">
                <img src="<?=SYS_PATH?>public/images/logo.svg">
              </div>
              <?php 
              if(count($err) > 0){
                flash($err[0], 0);
              }elseif(count($succ) > 0){
                flash($succ[0], 1);
              }
              ?>
              <form class="pt-3" action="" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                </div>
              <div class="form-group">
                <select name="school" id="school" class="form-control">
                  <option value="N">Select school</option>
                  <?php 
                  foreach( subscribed_school() as $sch ): ?>
                  <option value="<?=$sch['id']?>"><?=$sch['name']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
                <div class="mt-3">
                  <button type="submit" name="logg" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Connect</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="join-iosas" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?=SYS_PATH?>public/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?=SYS_PATH?>public/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?=SYS_PATH?>public/js/off-canvas.js"></script>
  <script src="<?=SYS_PATH?>public/js/misc.js"></script>
  <!-- endinject -->
</body>

</html>
