<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Purple Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?=SYS_PATH?>public/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?=SYS_PATH?>public/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css hash -->
  <link rel="stylesheet" href="<?=SYS_PATH?>public/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?=SYS_PATH?>public/images/favicon.png" />
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
              <form class="pt-3" action="/sys/access/join" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="username" placeholder="username">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
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
                  <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Join Us</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="/sys/access" class="text-primary">Login</a>
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
