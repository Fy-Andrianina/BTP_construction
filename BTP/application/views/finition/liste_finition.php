<!-- <p>Success</p> -->
<!-- <?php echo var_dump($data) ?> -->
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Liste des types de finitions</h4>
                  
                  <p class="card-description">
                     <!-- <code>.table-striped</code> -->
                  </p>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Designation</th>
                          <th>Pourcentage</th>
                         
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php foreach($data as $d){ ?>
                        <tr>
                          <td class="" style="text-align:left;">
                            <?php  echo $d['nom_finition'] ?>
                        </td>
                          <td class="" style="text-align:left;">
                          <?php  echo $d['pourcentage'] ?> %
                        </td>
                         
                        <td class="" style="text-align:right;">
                        <a class="text-success" href="<?php echo site_url() ?>FinitionController/update_form?idfinition=<?php echo $d['idfinition'] ?>"><button class="btn btn-outline-success btn-icon-text"><i class="typcn typcn-edit btn-icon-append"></i>Modifier</button></a>
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