<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <div class="d-flex sidebar-profile">
              <div class="sidebar-profile-image">
                <img src="images/faces/face29.png" alt="image">
                <span class="sidebar-status-indicator"></span>
              </div>
              <div class="sidebar-profile-name">
                <p class="sidebar-name">
                  <!-- <?php $user=$this->session->userdata('user');
                   if(isset($user[0]['admin'])){
                  echo $user[0]['numero']." ".$user[0]['prenom']; } ?> -->
                </p>
                <p class="sidebar-designation">
                  Welcome
                </p>
              </div>
            </div>
            <div class="nav-search">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Type to search..." aria-label="search" aria-describedby="search">
                <div class="input-group-append">
                  <span class="input-group-text" id="search">
                    <i class="typcn typcn-zoom"></i>
                  </span>
                </div>
              </div>
            </div>
            <p class="sidebar-menu-title">Dash menu</p>
          </li>
          <?php if(isset($user[0]['admin'])){ ?>
                    <li class="nav-item">
                      <a class="nav-link"  href="<?php echo base_url() ?>DashboardController">
                        <i class="typcn typcn-device-desktop menu-icon"></i>
                        <span class="menu-title"> Dashboard <span class="badge badge-primary ml-3">New</span></span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <i class="typcn typcn-briefcase menu-icon"></i>
                        <span class="menu-title">Devis</span>
                        <i class="typcn typcn-chevron-right menu-arrow"></i>
                      </a>
                      <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                          <li class="nav-item"> <a class="nav-link" href="<?php echo base_url() ?>PayeController/etat_paye">Etat de paye</a></li>
                          
                        </ul>
                      </div>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                        <i class="typcn typcn-film menu-icon"></i>
                        <span class="menu-title">Type Travaux</span>
                        <i class="menu-arrow"></i>
                      </a>
                      <div class="collapse" id="form-elements">
                        <ul class="nav flex-column sub-menu">
                          <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>TravauxController">Liste</a></li>
                        </ul>
                      </div>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                        <i class="typcn typcn-chart-pie-outline menu-icon"></i>
                        <span class="menu-title">Finition</span>
                        <i class="menu-arrow"></i>
                      </a>
                      <div class="collapse" id="charts">
                        <ul class="nav flex-column sub-menu">
                          <li class="nav-item"> <a class="nav-link" href="<?php echo base_url() ?>FinitionController">Liste de finition</a></li>
                        </ul>
                      </div>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                        <i class="typcn typcn-th-small-outline menu-icon"></i>
                        <span class="menu-title">Import</span>
                        <i class="menu-arrow"></i>
                      </a>
                      <div class="collapse" id="tables">
                        <ul class="nav flex-column sub-menu">
                          <li class="nav-item"> <a class="nav-link" href="<?php echo base_url() ?>ImportController">Import des données</a></li>
                        </ul>
                      </div>
                    </li>
                    
                    <li class="nav-item">
                      <a class="nav-link"  href="<?php echo base_url() ?>InitialiserController"  aria-controls="tables">
                          <i class="typcn typcn-refresh  menu-icon"></i>
                          <span class="menu-title">Reinitialiser la base </span>
                        </a>
                      <!-- <button class="btn btn-warning btn-icon-text" type="button"><a href="<?php echo base_url() ?>ImportController" style="color:white"><i class="typcn typcn-refresh btn-icon-prepend" ></i>Initialiser</a></button> -->
                    </li>
          <?php }else{ ?>
              <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                          <i class="typcn typcn-briefcase menu-icon"></i>
                          <span class="menu-title">Devis</span>
                          <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                          <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="<?php echo base_url() ?>DevisController">Liste de devis</a></li>
                            <li class="nav-item"> <a class="nav-link" href="<?php echo base_url() ?>DevisController/create_devis">Creer un devis</a></li>
                            
                          </ul>
                        </div>
                </li>

                <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                        <i class="typcn typcn-film menu-icon"></i>
                        <span class="menu-title">Payement de devis</span>
                        <i class="menu-arrow"></i>
                      </a>
                      <div class="collapse" id="form-elements">
                        <ul class="nav flex-column sub-menu">
                          <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>DevisController/unpayed_devis">Liste de devis</a></li>
                        </ul>
                      </div>
                    </li>


          <?php } ?>
         
        
      
      </nav>