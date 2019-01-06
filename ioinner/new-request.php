<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><%= title %></title>
  <link rel="stylesheet" href="<?=SYS_PATH?>public/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?=SYS_PATH?>public/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?=SYS_PATH?>public/css/style.css">
  <link rel="shortcut icon" href="<?=SYS_PATH?>public/images/favicon.png" />
  <!-- map css -->
  <link rel='stylesheet' id='pubnub-github-eon-style-css' href='//pubnub.github.io/eon/v/eon/1.0.0/eon.css' type='text/css' media='all'>
  <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.19.0.min.js"></script>
</head>
<body>
  <div class="container-scroller">
    <!-- Top dashboard nav -->
    <% include commons/top-dashboard-nav  %>
    <!-- end top dashboard nav -->
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <% include commons/side-nav %>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Dashboard
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Delivery Requests
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Service Request simulation</h4>
                  <div id="map" style="width:600px; height:auto;">

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Project Status</h4>
                  <div class="table-responsive">
                   
                  </div>
                </div>
              </div>
            </div>
          </div> -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
       <% include commons/footer %>
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1tLP5-7qxOWKnmFKWLW90aIgXx4Pi2eM&callback=initMap"></script>
    <script>
    // Initialize and add the map
    function initMap() {
    // The location of Uluru
    var labels = 'Khan Kimani, kileleshwa';
    var labelIndex = 0;
    var uluru = {lat: -1.2828711, lng: 36.8202874};
    // The map, centered at Uluru
    var map = new google.maps.Map(
    document.getElementById('map'), {zoom: 20, center: uluru});
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker(
      {position: uluru,
        map: map,
      title:"Alba and Associates",
      draggable: true,
      label: {
        text: labels,
        color: "#0077b4",
        fontSize: "18px",
        fontWeight: "bold"
      },
      animation: google.maps.Animation.DROP
      });
    }
    </script>
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
