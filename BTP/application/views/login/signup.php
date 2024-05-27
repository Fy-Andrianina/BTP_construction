<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>My Project</title>
  <!-- base:css -->
  <link rel="stylesheet" href="<?php echo site_url() ?>assets/vendors/typicons.font/font/typicons.css">
  <link rel="stylesheet" href="<?php echo site_url() ?>assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo site_url() ?>assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo site_url() ?>assets/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
       



          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="<?php echo site_url() ?>assets/logo.jpg" alt="logo">
              </div>
              <h4>Vous êtes nouveau ?</h4>
              <h6 class="font-weight-light">S'inscrire c'est facile. Cela ne prendra que quelques étapes</h6>
              <form class="pt-3" action="<?php echo site_url() ?>loginController/process_Sign_Up" method="post">
          
                <div class="form-group first">
                  <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" name="nom" placeholder="Nom d'utilisateur">
                  <p class="errors"><?php echo form_error('nom'); ?></p>

                </div>
                <div class="form-group first">
                  <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="prenom" placeholder="Prenom">
                  <p class="errors"><?php echo form_error('prenom'); ?></p>

                </div>
                <div class="form-group first">
                  <input type="date" class="form-control form-control-lg" id="exampleInputEmail1" name="dtn" placeholder="Date de naissance">
                  <p class="errors"><?php echo form_error('dtn'); ?></p>

                </div>
                <div class="form-group first">
                <p class="errors"><?php echo form_error('sexe'); ?></p>

                  <select class="form-control form-control-lg" name="sexe" id="exampleFormControlSelect2">
                    <option default>Sexe</option>
                    <option value="1">Homme</option>
                    <option value="0">Femme</option>
                  </select>
                </div>
                <div class="mt-3 first">
                  <button class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn suivant" type="button" onclick="hide_first()">Suivant</button>
                </div>

                <div class="form-group second" style="display:none;">

                  <input type="email" class="form-control form-control-lg" id="exampleInputUsername1" name="email" placeholder="E-mail">
                  <p class="errors"><?php echo form_error('email'); ?></p>
                
                </div>
                <div class="form-group second" style="display:none;">
                  <input type="password" class="form-control form-control-lg pass_1" id="exampleInputPassword1" placeholder="Mot de passe">
                  <p class="errors"><?php echo form_error('password'); ?></p>
                </div>
                <div class="form-group second" style="display:none;">
                  <input type="password" class="form-control form-control-lg pass_2" id="exampleInputPassword1" name="password" onchange="check_pass()" placeholder="Confirmation de Mot de passe">
                </div>
                <div class="mt-3 second" style="display:none;">
                  <button class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="button" onclick="hide_second()" style="background-color:#57c7d4">Précédent</button>
                </div>
                <div class="mt-3 second" style="display:none;">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn " id="sign" type="submit" value="INSCRIPTION" disabled>
                </div>
                <div class="text-center mt-4 font-weight-light second" style="display:none;">
                  Vous avez déjà un compte ? <a href="<?php echo site_url()?>LoginController" class="text-info">Se connecter</a>
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
  <!-- base:js -->
  <script src="<?php echo site_url() ?>assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?php echo site_url() ?>assets/js/off-canvas.js"></script>
  <script src="<?php echo site_url() ?>assets/js/hoverable-collapse.js"></script>
  <script src="<?php echo site_url() ?>assets/js/template.js"></script>
  <script src="<?php echo site_url() ?>assets/js/settings.js"></script>
  <script src="<?php echo site_url() ?>assets/js/todolist.js"></script>
  <script>
    function hide_first() {
      var first = document.querySelectorAll(".first");
      var second = document.querySelectorAll(".second");

      first.forEach(function(item) {
        item.style.display = "none";
      });

      second.forEach(function(item) {
        item.style.display = "flex";
      });
    }

    function hide_second() {
      var first = document.querySelectorAll(".first");
      var second = document.querySelectorAll(".second");

      first.forEach(function(item) {
        item.style.display = "flex";
      });

      second.forEach(function(item) {
        item.style.display = "none";
      });
    }

    function check_pass(){
      var sign_btn=document.getElementById("sign");

        var pass1 = document.querySelector('.pass_1').value;
        var pass2 = document.querySelector('.pass_2').value;
       console.log(pass1);
        if (pass1 === pass2) {
          sign_btn.removeAttribute("disabled");
        }
    }
  </script>
<style>
  .errors{
    color:"red";
  }
</style>
</body>

</html>
