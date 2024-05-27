<!-- <link rel="stylesheet" href="<?php echo base_url('assets/erreur/erreur_css.css'); ?>" scoped> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js" scoped></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->


<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Payement</h4>
            <p class="card-description">
                Payement du devis
            </p>
            <?php if (isset($error)) {
                echo "<h2 class=\"text-danger\"  >" . $error . "</h2>";
            } ?>
            <h2 id="error" class="text-danger"></h2>
            <form id="paye" class="forms-sample">
                <div class="form-group">
                    <label for="exampleInputName1">Montant:</label>
                    <input type="text" name="montant" class="form-control" id="exampleInputName1" placeholder="Montant" required min="1">
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
            <div id="errorModalContainer"></div>
        </div>
    </div>
</div>


<script>
$(document).ready(function(){
    $('#paye').submit(function(e){

        // Empêcher le comportement par défaut du formulaire, qui est de recharger la page
        e.preventDefault(); 

        var montant = $(this).find('[name="montant"]').val();
        var date = $(this).find('[name="date"]').val();
        var devis_client=$(this).find('[name="iddevis_client"]').val();
        // var error=$(this).find(['id="error']);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>PayeController/process_payment',
            data: { montant:montant, date:date ,iddevis_client:devis_client},
            success: function(response){
                var data = JSON.parse(response);
                console.log(data);

                // Vérifiez s'il y a un message d'erreur dans la réponse JSON
                if (data.error_message) {
                    // Affichez le message d'erreur dans l'élément avec l'ID "error"
                    $("#error").html(data.error_message);
                    // Affichez l'élément avec l'ID "error" en utilisant CSS flex
                    $("#error").css("display", "flex");
                    // Affichez également une alerte avec le message d'erreur (pour le débogage)
                    alert(data.error_message);
                } else {
                    // Si pas d'erreur, redirigez l'utilisateur vers l'URL spécifiée dans la réponse JSON
                    window.location.href = data.redirect;
                }
            },
            error: function(xhr, status, error){
                alert(error);
                console.error('Erreur lors de la requête AJAX : ' + xhr.status);
            }
        });
        
        
    });
});
</script>