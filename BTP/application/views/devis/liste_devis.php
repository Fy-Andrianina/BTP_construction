<!-- <p>Success</p> -->
<!-- <?php echo var_dump($data) ?> -->
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Liste de vos devis</h4>
                  <button class="btn btn-info"><a href="<?php echo site_url() ?>DevisController/create_devis" style="color:white">Creer un devis</a></button>
                  <p class="card-description">
                     <!-- <code>.table-striped</code> -->
                  </p>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            Date Creation
                          </th>
                          <th>
                            Finition
                          </th>
                          <th>
                            Montant devis
                          </th>
                          <th>Reste A payer</th>
                          <th>Date debut travaux</th>
                          <th>Date fin travaux</th>
                          <th>Exporter</th>
                          <th>Payer</th>

                        </tr>
                      </thead>
                      <tbody>
                       <?php foreach($data as $d){ ?>
                        <tr>
                          <td class="" style="text-align:left;">
                            <?php  echo $d['date'] ?>
                        </td>
                          <td class="" style="text-align:left;">
                          <?php  echo $d['nom_finition'] ?>
                        </td>
                          <td class="" style="text-align:right;">
                          <?php  echo number_format($d['montant_avec_finition'],2,',',' ') ?>
                        </td>
                        <td class="" style="text-align:right;">
                          <?php  echo number_format($d['reste_a_payer'],2,',',' ') ?>
                        </td>
                        <td class="" style="text-align:center;">
                        <?php  echo $d['date_debut'] ?>
                        </td>
                        <td style="text-align:center;"> <?php  echo $d['date_fin'] ?></td>
                        <td style="text-align:center;"><button class="btn btn-outline-info btn-icon-text"><i class="typcn typcn-printer btn-icon-append"></i><a href="<?php echo site_url() ?>DevisController/ExportPDF?iddevis_client=<?php echo $d['iddevis_client'] ?>">Exporter PDF</a></button></td>
                        
                        <td>
                        <?php  if($d['reste_a_payer']==0){ ?>
                          <label for="" class="badge badge-success">Completed</label>
                          <?php }else{ ?>
                            <button class="btn btn-outline-warning btn-icon-text"><i class="typcn typcn-printer btn-icon-append"></i><a href="<?php echo site_url() ?>PayeController?iddevis_client=<?php echo $d['iddevis_client'] ?>" class="text-warning">Payer</a></button>
                            <?php } ?>
                        </td>  
                      </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <div class="pagination">
                        <?php echo $links; ?>
                     </div>
                  </div>
                </div>
              </div>
            </div>