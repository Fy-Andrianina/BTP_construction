<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Creation de Devis</h4>
            <p class="card-description">
                Creer un nouveau <code>Devis</code>.
            </p>
            <?php if (isset($error)) {
                echo "<h2 class=\"text-danger\">" . $error . "</h2>";
            }if (isset($success)) {
                echo "<h2 class=\"text-success\">" . $succes . "</h2>";
            } ?>

            <form action="<?php echo site_url() ?>DevisController/form_creation_devis" method="post">
                <div class="form-group">
                    <label for="exampleInputUsername2" class="col-form-label">Les Maisons</label>

                    <div class="form-group row">
                        <?php foreach ($type_maisons as $type_maison) { ?>
                            <div class="col-sm-3  maisons">
                                <h2><?php echo $type_maison['nom_maison'] ?></h2>
                               <code> <h3><?php echo number_format($type_maison['montant'],2,',',' ') ?></h3></code>
                                <p><?php echo $type_maison['description'] ?></p>

                                <input  <?php if(isset($default_maison) && $type_maison['idtype_maison']==$default_maison){ echo "checked"; } ?> style="justify-self: center;" type="radio" name="type_maison" value="<?php echo $type_maison['idtype_maison'] ?>">
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Type de finition</label>
                        <div class="col-sm-9">
                            <select name="type_finition" class="form-control form-control-lg">
                                <?php foreach ($type_finitions as $finition) { ?>
                                    <option <?php if(isset($default_finition) && $finition['idfinition']==$default_finition){ echo "selected"; } ?> value="<?php echo $finition['idfinition'] ?>"><?php echo $finition['nom_finition'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Lieu</label>
                        <div class="col-sm-9">
                            <select name="idlieu" class="form-control form-control-lg">
                                <?php foreach ($lieux as $l) { ?>
                                    <option <?php if(isset($default_lieu) && $l['idlieu']==$default_lieu){ echo "selected"; } ?> value="<?php echo $l['idlieu'] ?>"><?php echo $l['nom_lieu'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Date debut de construction</label>
                        <div class="col-sm-9">
                            <input type="date" name="date_debut" class="form-control" id="" required  value="<?php if(isset($default_date_debut)){ echo $default_date_debut;  } ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Date de creation</label>
                        <div class="col-sm-9">
                            <input type="date" name="date" class="form-control" value="<?php if(isset($default_date)){ echo $default_date; } ?>" id=""  required>
                        </div>
                    </div>


                    <input type="submit" value="Soumettre" class="btn btn-info mr-2">
                    <button class="btn btn-light"><a href="<?php echo site_url() ?>DevisController">Cancel</a></button>

                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .maisons {

        margin: 10px;
    }

    .maisons:hover {
        /* border-style: inset; */
        border-right-style: inset;
        border-bottom-style: inset;
        /* margin: 10px; */
    }
</style>
<script>

</script>