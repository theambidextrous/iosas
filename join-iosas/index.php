<?php 
 $err = [];
 $succ = [];
require_once("../iosys/inf.ionf.conf.php");
//form
if(isset($_POST['join'])){
  $username = secure($_POST['username']);
  $email = secure($_POST['email']);
  $password = secure($_POST['password']);
  $school = secure($_POST['school']);
  if( empty($username) || empty($email) ||  empty($password) || empty($school) || $school == 'N' ){
    array_push($err, 'Empty field detected, please correct');
  }elseif(!ValidateEmail($email)){
    array_push($err, 'Invalid email Address : <b>'.$email.'</b>, please correct');
  }else{
   //username,email,pasword,school
  $data = [$username, $email, $password, $school];
  $resp = createNewSysUsers($data);
  if(!hasPdoErr($resp)){
    if($resp == 1){
      array_push($succ, 'Account created, your Administrator will notify you once it is activated');
    }else{
      array_push($err, 'Some errors occured. Rolling back...');
    }
  }else{
    array_push($err, 'Some errors occured. Most likely a similar record exists. Rolling back...');
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
                  <input type="text" class="form-control form-control-lg" name="username" placeholder="username">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                <select name="school" id="school" class="form-control">
                  <option value="N">Select your school</option>
                  <?php 
                  foreach( subscribed_school() as $sch ): ?>
                  <option value="<?=$sch['id']?>"><?=$sch['name']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      I agree to all Terms & Conditions
                    </label>
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" name="join" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Join iosas</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="../" class="text-primary">Login here</a>
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
