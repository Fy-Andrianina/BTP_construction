<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Payement</h4>
            <p class="card-description">
                Payement du devis
            </p>
            <?php if (isset($error)) {
                echo "<h2 class=\"text-danger\">" . $error . "</h2>";
            } ?>
            <form class="forms-sample" action="<?php echo site_url() ?>PayeController/process_payment" method="post">
                <div class="form-group">
                    <label for="exampleInputName1">Montant:</label>
                    <input type="number" name="montant" class="form-control" id="exampleInputName1" placeholder="Montant" required min="1">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Date:</label>
                    <input type="date" name="date" class="form-control" id="exampleInputName1" placeholder="Date de payement" required>
                    <input type="hidden" name="iddevis_client" value="<?php echo $iddevis_client ?>">
                </div>

                <!-- <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                <input type="submit" value="Payer" class="btn btn-info mr-2">
                <button class="btn btn-light"> <a href="<?php echo site_url() ?>DevisController">Quitter</a></button>
            </form>
        </div>
    </div>
</div>