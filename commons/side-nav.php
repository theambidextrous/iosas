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
      <!-- <li class="nav-item">
        <a class="nav-link" href="/sys/access/dashboard">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li> -->
      <?php  
      $loop = 0;
        foreach( getPermissionParents() as $pp ):
      ?>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic<?=$loop?>" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title"><?=$pp['parent']?></span>
          <i class="menu-arrow"></i>
          <i class="mdi <?=$pp['parent_icon']?>"></i>
        </a>
        <div class="collapse" id="ui-basic<?=$loop?>">
          <ul class="nav flex-column sub-menu">
          <?php foreach( getParentPermissions($pp['parent']) as $inner ): 
          if(in_array($inner['id'], $user_permissions)){
            ?>
            <li class="nav-item"> <a class="nav-link" href="?to=<?=$inner['name']?>"><?=$inner['name']?></a></li>
            <?php 
          }
            endforeach;
            ?>
          </ul>
        </div>
      </li>
          <?php 
          $loop++;
          endforeach;
          ?>
    </ul>
  </nav>