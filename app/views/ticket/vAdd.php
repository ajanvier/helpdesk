<form method="post" action="Tickets/add">
    <fieldset>
        <legend>Créer un ticket</legend>
        <div class="form-group">
            <select name="type" class="form-control">
                <option disabled selected>Type</option>
                <option disabled>---</option>
<?php foreach($ticketTypes as $type => $libelle) {  ?>
                <option value="<?php echo $type; ?>"><?php echo $libelle; ?></option>
<?php } ?>
            </select>
            <br />
            <select name="categorie" class="form-control">
                <option disabled selected>Catégorie</option>
                <option disabled>---</option>
<?php foreach($categories as $cat) {  ?>
                    <option value="<?php echo $cat->getId(); ?>"><?php echo $cat; ?></option>
<?php } ?>
            </select>
            <br />
            <label for="titre">Titre :</label>
            <br /><input type="text" class="form-control" id="titre" name="titre" />
            <br />
            <label for="description">Description :</label>
            <br />
            <textarea id="description" class="form-control" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="utilisateur">Utilisateur :</label>
            <br /><input type="text" class="form-control" id="utilisateur" name="utilisateur" readonly />
            <br />
            <label for="datecreation">Date de création :</label>
            <br /><input type="text" class="form-control" id="datecreation" name="datecreation" readonly value="<?php echo (new DateTime())->format('d-m-Y H:i:s'); ?>" />
            <br />
            <label for="statut">Statut :</label>
            <br /><input type="text" class="form-control" id="statut" name="statut" readonly />
        </div>
        <div class="form-group">
            <input type="submit" value="Valider" class="btn btn-default">
            <a class="btn btn-default" href="<?php echo $config["siteUrl"]?>Tickets">Annuler</a>
        </div>
    </fieldset>
</form>
