<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>My Project</title>
  <!-- base:css -->
  <link rel="stylesheet" href="<?php echo site_url() ?>/assets/vendors/typicons.font/font/typicons.css">
  <link rel="stylesheet" href="<?php echo site_url() ?>/assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo site_url() ?>/assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo site_url() ?>/assets/images/favicon.png" />
</head>

<body>
  <script>
<?php if(isset($error)){ ?>
  alert('<?php echo $error ?>');
  <?php } ?>
  </script>
  
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <!-- <div class="col-lg-4" style="text-align:end">
          <img src="<?php echo site_url() ?>assets/img.jpg" alt="logo">
          </div> -->
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="<?php echo site_url() ?>/assets/logo.jpg" alt="logo">
              </div>
              <h4>Bonjour! Soyez le bienvenue</h4>
              <h6 class="font-weight-light">Connectez-vous pour continuer.</h6>
              <form class="pt-3" action="<?php echo site_url() ?>loginController" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="numero" id="exampleInputEmail1" placeholder="Numero de telephone" maxlength="10">
                  <?php echo form_error('numero'); ?>
                </div>
                
                <div class="mt-3">
                 <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" value="CONNEXION"> 
                </div>
               
                
                <div class="text-center mt-4 font-weight-light">
                  Se connecter en tant qu' <a href="<?php echo site_url() ?>loginController/form_admin" class="text-info">Admin</a>
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
  <script src="<?php echo site_url() ?>/assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?php echo site_url() ?>/assets/js/off-canvas.js"></script>
  <script src="<?php echo site_url() ?>/assets/js/hoverable-collapse.js"></script>
  <script src="<?php echo site_url() ?>/assets/js/template.js"></script>
  <script src="<?php echo site_url() ?>/assets/js/settings.js"></script>
  <script src="<?php echo site_url() ?>/assets/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
