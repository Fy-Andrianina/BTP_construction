<!-- <p>Success</p> -->
<!-- <?php echo var_dump($data) ?> -->
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Detail du devis</h4>
                
                  <p class="card-description">
                     <!-- <code>.table-striped</code> -->
                  </p>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                        <th>Designation</th>
                        <th>Unite</th>
                        <th>Quantite</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>

                        </tr>
                      </thead>
                      <tbody>
                     <?php foreach ($data as $d) { ?>
           
                            <tr>
                                
                                <td style="text-align:left;"><?php echo $d['nom_type_travaux'] ?></td>
                                <td style="text-align: center;"><?php echo $d['abbreviation'] ?></td>
                                <td style="text-align: right;"><?php echo $d['quantite'] ?></td>
                                <td style="text-align: right;" ><?php echo number_format($d['prix_unitaire'], 2, '.', ' ') ?></td>
                                <td style="text-align: right;"><?php echo number_format($d['montant'], 2, '.', ' ') ?></td>
                                </tr>
        
                        <?php } ?>
                        <tr>
                            <td colspan="4" style="text-align:end">Montant sans finition</td>
                            <td><?php echo number_format($devis_client[0]['montant_sans_finition'], 0, ',', ' ') ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:end">Montant avec finition</td>
                            <td><?php echo number_format($devis_client[0]['montant_avec_finition'], 0, ',', ' ') ?></td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="pagination">
                        <?php echo $links; ?>
                     </div>
                  </div>
                </div>
              </div>
            </div>