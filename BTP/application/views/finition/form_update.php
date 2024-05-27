<div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Modification d'une finition </h4>
                  <p class="card-description">
                    Modifier le pourcenatage de <code><?php echo $type_finition['nom_finition'] ?></code>
                  </p>
                  <?php if (isset($error)) {
                       echo "<h6 class=\"text-danger\">" . $error . "</h6>";
                 } ?>
                  <form class="forms-sample" action="<?php echo site_url() ?>FinitionController/process_update" method="post">
                   
                    <div class="form-group">
                      <label for="exampleInputEmail1">Poucentage</label>
                      <input  type="text" name="pourcentage" class="form-control" id="exampleInputEmail1"  required  placeholder="Pourcentage" onchange="check_pourcentage(this.value)"
                      <?php if(isset($default_pourcentage)){ ?> 
                            value="<?php echo $default_pourcentage ?>"
                        <?php }else{ ?>
                            value="<?php echo $type_finition['pourcentage'] ?>"
                            <?php } ?> >
                            <h6 class="text-danger" style="display: none;" id="error"></h6>
                    </div>
                    
                    <input type="hidden" name="idfinition" value="<?php echo $type_finition['idfinition'] ?>">
                   <input type="submit" class="btn btn-info mr-2" value="Modifier">
                  
                    <button class="btn btn-light"> <a href="<?php echo site_url() ?>FinitionController/index">Quitter</button>
                  </form>
                </div>
              </div>
            </div>
            <script>
              function check_pourcentage(inputValue){
              // Récupérer la valeur de l'input
                    // var inputValue = document.getElementById('exampleInputEmail1').value;
                    var error=document.getElementById('error');
                    // Définir une expression régulière pour vérifier les caractères non alphanumériques
                    var regex = /[^a-zA-Z0-9]/;

                    // Vérifier si la valeur contient des caractères non alphanumériques
                    if (regex.test(inputValue)) {
                        // La valeur contient des caractères non alphanumériques
                       error.innerHTML="La valeur contient des caractères non alphanumériques.";
                       error.style.display="flex";
                    }
                    else {
                      error.style.display="none";

                        // console.log("La valeur ne contient que des caractères alphanumériques.");
                    }
              }

            </script>