<div class="col-xl-5 d-flex grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <!-- Total devis et total de payement effectuer -->
                    <div class="d-flex flex-wrap justify-content-between">
                      <h4 class="card-title mb-3">Statistique</h4>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="mb-5">
                          <div class="mr-1">
                            <div class="text-info mb-1">
                              Total devis
                            </div>
                            <h2 class="mb-2 mt-2 font-weight-bold"> <?php echo number_format($total_devis,2,',',' '); ?> Ar</h2>
                            <div class="font-weight-bold">
                           
                            </div>
                          </div>
                          <hr>
                          <div class="mr-1">
                            <div class="text-info mb-1">
                              Total Payement effectuer
                            </div>
                            <h2 class="mb-2 mt-2  font-weight-bold"><?php echo  number_format($total_payement,2,',',' '); ?> Ar</h2>
                            <div class="font-weight-bold">
                            
                            </div>
                          </div>
                        </div>
                       
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                      <h4 class="card-title mb-3">Devis de l'annee <?php echo $annee ?></h4>
                    </div>
                  <form action="<?php echo site_url()?>DashboardController" method="post">
                    <div class="form-group">
                          <label for="annee">Annee</label>
                          <select name="annee" id="annee" class="form-control">
                            <?php for($an=2026;$an>2010;$an--){ ?>
                            <option value="<?php echo $an ?>"><?php echo $an ?></option>
                            <?php } ?>
                          </select>
                          
                      </div>
                      <div class="form-group">
                        <input type="submit" class="btn btn-outline-info" value="Envoyer">
                      </div>
                  </form>

                    <canvas id="barChart"></canvas>
                  </div>
                </div>
              </div>


              <script type="text/javascript">
                  var my_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                  var my_label = [
                    "Janvier",
                    "Février",
                    "Mars",
                    "Avril",
                    "Mai",
                    "Juin",
                    "Juillet",
                    "Août",
                    "Septembre",
                    "Octobre",
                    "Novembre",
                    "Décembre"
                  ];

                  <?php foreach($data as $d){ ?>
                    my_data[<?php echo $d['mois'] - 1 ?>] = <?php echo $d['montant'] ?>;
                  <?php } ?>
</script>

  <script src="<?php echo site_url() ?>assets/jquery-3.7.1.js"></script>
             
  <script src="<?php echo site_url() ?>/assets/js/chart.js"></script>
