<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" >
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="height:80px">
          <a class="navbar-brand brand-logo" href="index.html"><img src="<?php echo site_url() ?>assets/logo.jpg" alt="logo" style="height:80px"/></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="<?php echo site_url() ?>assets/logo.jpg" alt="logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="height:80px">
         
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-lg-flex  mr-2">
              <a class="nav-link" href="#">
                Se deconnecter
              </a>
            </li>
           
           
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
                <i class="typcn typcn-user-outline mr-0"></i>
                <span class="nav-profile-name">
                  <?php $user=$this->session->userdata("user");
         if(isset($user[0]['admin'])){ echo $user[0]['nom']." ".$user[0]['prenom']; }   ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item">
               
                <a class="dropdown-item" href="<?php echo  site_url() ?>loginController/disconnect">
                <i class="typcn typcn-power text-primary"></i>
                Logout
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
      </nav>