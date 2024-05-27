<!-- <p>Success</p> -->
<!-- <?php echo var_dump($data) ?> -->
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Liste de vos devis</h4>
                 
                  <p class="card-description">
                     <!-- <code>.table-striped</code> -->
                  </p>
                  <div class="table-responsive">
                    <table class="table ">
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
                          <th>Dejà payer</th>

                        <th>Pourcentage</th>

                        </tr>
                      </thead>
                      <tbody>
                       <?php foreach($data as $d){ ?>
                        <tr <?php if($d['pourcentage_effectuer']<50){ ?>
                                  class="text-danger" 
                              <?php }else if($d['pourcentage_effectuer']>50){ ?>
                                   class="text-success"
                              <?php } ?>>
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
                        <?php  echo number_format($d['montant_paye'],2,',',' ') ?>
                       </td>
                       <td  >
                        <?php  echo  number_format($d['pourcentage_effectuer'], 3) ?>%
                       </td>
                       <td>
                        <?php if($d['reste_a_payer']==0){ ?>
                          <label for="" class="badge badge-success">Completed</label>
                          <?php }else{ ?>
                            <label for="" class="badge badge-warning">En cours</label>
                            <?php } ?>
                        </td>
                        <td><a href="<?php echo site_url() ?>PayeController/detail_devis?iddevis_client=<?php echo $d['iddevis_client'] ?>" class="text-success"> <button class="btn btn-outline-success btn-icon-text"><i class="typcn typcn-printer btn-icon-append"></i>Details</button></a></td>
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