<div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Modification d'un type de travaux</h4>
                  <p class="card-description">
                    Modifier
                  </p>
                  <?php if (isset($error)) {
                       echo "<h2 class=\"text-danger\">" . $error . "</h2>";
                 } ?>
                  <form class="forms-sample" action="<?php echo site_url() ?>TravauxController/process_update" method="post">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Designation</label>
                      <input type="text" name="nom_type_travaux" class="form-control" id="exampleInputUsername1" required 
                        <?php if(isset($default_nom)){ ?> 
                                value="<?php echo $default_nom ?>"
                            <?php }else{ ?>
                                value="<?php echo $type_travaux['nom_type_travaux'] ?>"
                                <?php } ?>
                            >
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Prix Unitaire</label>
                      <input type="text" name="prix_unitaire" class="form-control" id="exampleInputEmail1"  min="1" required  placeholder="PrixUnitaire"
                      <?php if(isset($default_prix)){ ?> 
                            value="<?php echo $default_prix ?>"
                        <?php }else{ ?>
                            value="<?php echo $type_travaux['prix_unitaire'] ?>"
                            <?php } ?> >
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Unite</label>
                      <select name="unite" id="" class="form-control">
                        <?php foreach($unites as $unite){ ?>
                            <option 
                            <?php if(isset($default_unite)){ if($unite['idunite']==$default_unite){ echo "selected"; }
                                }else{ 
                                    if($unite['idunite']==$type_travaux['idunite']){ echo "selected"; } } ?>

                            value="<?php echo $unite['idunite'] ?>"><?php echo $unite['nom_unite']." ". $unite['abbreviation']?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <input type="hidden" name="idtype_travaux" value="<?php echo $type_travaux['idtype_travaux'] ?>">
                   <input type="submit" class="btn btn-info mr-2" value="Modifier">
                  
                    <button class="btn btn-light"> <a href="<?php echo site_url() ?>TravauxController/index">Quitter</button>
                  </form>
                </div>
              </div>
            </div>