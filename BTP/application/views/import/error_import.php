<div class="table-responsive">
   <a href="<?php echo site_url()?>ImportController"><button class="btn btn-primary">Retour</button></a>
    <table class="table table-striped">
        <h2>Erreur d'import </h2>
        <thead>
            <th>Ligne</th>
            <th>Type d'erreur</th>
        </thead>
        <tbody>
            <?php foreach($error as $e){ ?>
                <tr>
                    <td><?php echo $e['ligne'] ?> </td>
                    <td><?php echo $e['type_erreur'] ?> </td>
                </tr>
                <?php } ?>
        </tbody>
    </table>

</div>