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
                  <span></span>In transit
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Realtime(simulation) -screen recording</h4>
                  <div id="map" style="width:600px; height:auto;">
                    <iframe style="min-width: 128%;min-height: 500px;" frameborder="0" scrolling="no" width="100%" height="100%"
                    src="<?=SYS_PATH?>public/images/demo/source.gif" name="imgbox" id="imgbox">
                    <p>iframes are not supported by your browser.</p>
                    </iframe><br />
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
  <script src='//pubnub.github.io/eon/v/eon/1.0.0/eon.js'></script>
  <script>
    L.RotatedMarker = L.Marker.extend({
        options: {
            angle: 0
        },
        _setPos: function(pos) {
            L.Marker.prototype._setPos.call(this, pos);
            if (L.DomUtil.TRANSFORM) { // use the CSS transform rule if available
                this._icon.style[L.DomUtil.TRANSFORM] += ' rotate(' + this.options.angle + 'deg)';
            } else if (L.Browser.ie) { // fallback for IE6, IE7, IE8
                var rad = this.options.angle * L.LatLng.DEG_TO_RAD,
                    costheta = Math.cos(rad),
                    sintheta = Math.sin(rad);
                this._icon.style.filter += ' progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=' +
                    costheta + ', M12=' + (-sintheta) + ', M21=' + sintheta + ', M22=' + costheta + ')';
            }
        }
    });
    var pn = new PubNub({
        publishKey: 'pub-c-5d06f27d-377e-46ed-a033-dc955ea36ae7',
        subscribeKey: 'sub-c-c63a3a24-f84f-11e8-a860-92908bb92f21',
        ssl: (('https:' == document.location.protocol) ? true : false)
    });
    var map = eon.map({
        pubnub: pn,
        id: 'map',
        mbId: 'bytebladesystems.cjpat9s3j1ntq2woabmfip5fq-4rca9',
        mbToken: 'pk.eyJ1IjoiYnl0ZWJsYWRlc3lzdGVtcyIsImEiOiJjam45c2d3YXE0NWZ1M3dxdm81c3ViMXh5In0.6ACLmL4QXsmB1nlF3evGYQ',
        channels: ['pd-maps-chan'],
        rotate: true,
        history: true,
        marker: function(latlng, data) {
            var marker = new L.RotatedMarker(latlng, {
                icon: L.icon({
                    iconUrl: 'http://clipartmag.com/images/location-icon-png-41.png',
                    iconSize: [9, 32]
                })
            });
            marker.bindPopup('Route ' + data.routeTag.toUpperCase());
            return marker;
        }
    });
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
