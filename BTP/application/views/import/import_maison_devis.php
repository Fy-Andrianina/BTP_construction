<div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Import </h4>
                  <p class="card-description">
                   Importer des fichier <code>CSV</code>
                  </p>
                  <?php if (isset($error)) {
                       echo "<h6 class=\"text-danger\">" . $error . "</h6>";
                 } ?>
                  <form class="forms-sample" action="<?php echo site_url() ?>importController/import_maison_devis" method="post" enctype="multipart/form-data">
                   
                    <div class="form-group">
                      <label for="exampleInputEmail1">Maison et travaux</label>
                      <input  type="file" name="fichier_maison_travaux" class="form-control" id="exampleInputEmail1"  required  placeholder="Maison et travaux"  >
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Devis</label>
                      <input  type="file" name="fichier_devis" class="form-control" id="exampleInputEmail1"  required  placeholder="Devis"  >
                    </div>
                    
                   
                   <input type="submit" class="btn btn-info mr-2" value="Importer">
                  
                    
                  </form>
                </div>
              </div>
            </div>



            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Import Payement </h4>
                  <p class="card-description">
                   Importer des fichier <code>CSV</code>
                  </p>
                  <?php if (isset($error)) {
                       echo "<h6 class=\"text-danger\">" . $error . "</h6>";
                 } ?>
                  <form class="forms-sample" action="<?php echo site_url() ?>importController/import_payement" method="post" enctype="multipart/form-data">
                   
                    <div class="form-group">
                      <label for="exampleInputEmail1">Payement</label>
                      <input  type="file" name="fichier_paiement" class="form-control" id="exampleInputEmail1"  required  placeholder="Payement"  >
                    </div>
                    
                   <input type="submit" class="btn btn-info mr-2" value="Importer">
                  
                    
                  </form>
                </div>
              </div>
            </div>