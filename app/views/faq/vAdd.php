<form method="post" action="faqs/update">
    <fieldset>
        <legend>Créer un article</legend>
        <div class="form-group">
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
            <textarea id="description" class="form-control" name="contenu"></textarea>
            <?php echo JsUtils::execute("CKEDITOR.replace( 'description');"); ?>
        </div>
        <div class="form-group" style="width:70%; float:left;">
            <label for="utilisateur">Utilisateur :</label>
            <br /><input type="text" class="form-control" id="utilisateur" readonly value="<?php echo $currentUser->getLogin(); ?>" />
            <br />
            <label for="datecreation">Date de création :</label>
            <br /><input type="text" class="form-control" id="datecreation" readonly value="<?php echo (new DateTime())->format('d-m-Y H:i:s'); ?>" style="width:50%;" />
            <br />
            <label for="version">Version :</label>
            <br /><input type="text" class="form-control" id="version" name="version" readonly value="1.0" style="width:50%;" />
        </div>
        <div class="form-group" style="width:30%; float:right; padding-top:150px">
            <input type="submit" value="Valider" class="btn btn-default" style="width:100%;" />
            <br /><a class="btn btn-default" href="<?php echo $config["siteUrl"]?>Faqs" style="width:100%;">Annuler</a>
        </div>
    </fieldset>
</form>
