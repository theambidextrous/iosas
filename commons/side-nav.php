<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="<?=SYS_PATH?>public/images/faces/face1.jpg" alt="profile">
            <span class="login-status online"></span> <!--change to offline or busy as needed-->              
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2"><?=$_SESSION['USNM'] ?></span>
            <span class="text-secondary text-small">PD Admin</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sys/access/dashboard">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Administration</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="/sys/access/requests">Delivery Requests</a></li>
            <li class="nav-item"> <a class="nav-link" href="/sys/access/realtime">In Transit</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sys/access/dashboard">
          <span class="menu-title">Riders & Drivers</span>
          <i class="mdi mdi-contacts menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sys/access/dashboard">
          <span class="menu-title">Warehouses</span>
          <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sys/access/dashboard">
          <span class="menu-title">Statistics</span>
          <i class="mdi mdi-chart-bar menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sys/access/dashboard">
          <span class="menu-title">Reports</span>
          <i class="mdi mdi-table-large menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="/sys/access/dashboard" aria-expanded="false" aria-controls="general-pages">
          <span class="menu-title">Settings</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-medical-bag menu-icon"></i>
        </a>
        <div class="collapse" id="general-pages">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="/sys/access/dashboard"> Server info </a></li>
            <li class="nav-item"> <a class="nav-link" href="/sys/access/dashboard"> System settings </a></li>
            <li class="nav-item"> <a class="nav-link" href="/sys/access/dashboard"> Add users </a></li>
            <li class="nav-item"> <a class="nav-link" href="/sys/access/dashboard"> Misc </a></li>
          </ul>
          </div>
      </li>
      <li class="nav-item sidebar-actions">
        <span class="nav-link">
          <div class="border-bottom">
            <h6 class="font-weight-normal mb-3">Offices</h6>                
          </div>
          <button class="btn btn-block btn-lg btn-gradient-primary mt-4">+ Add an office</button>
          <div class="mt-4">
            <div class="border-bottom">
              <p class="text-secondary">Parcel Categories</p>                  
            </div>
            <ul class="gradient-bullet-list mt-4">
              <li>Builky</li>
              <li>Lightweight</li>
            </ul>
          </div>
        </span>
      </li>
    </ul>
  </nav>