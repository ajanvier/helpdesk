<form method="post" action="faqs/update">
    <fieldset>
        <legend>Modifier un article</legend>
        <div class="form-group">
            <select name="categorie" class="form-control">
                <option disabled selected>Catégorie</option>
                <option disabled>---</option>
                <?php foreach($categories as $cat) {  ?>
                    <option value="<?php echo $cat->getId(); ?>"<?php echo ($cat->getId() == $article->getCategorie()->getId()) ? " selected" : ""; ?>><?php echo $cat; ?></option>
                <?php } ?>
            </select>
            <br />
            <label for="titre">Titre :</label>
            <br /><input type="text" class="form-control" id="titre" name="titre" value="<?php echo $article->getTitre(); ?>" />
            <br />
            <label for="description">Description :</label>
            <br />
            <textarea id="description" class="form-control" name="contenu"><?php echo $article->getContenu(); ?></textarea>
            <?php echo JsUtils::execute("CKEDITOR.replace( 'description');"); ?>
        </div>
        <div class="form-group">
            <label for="utilisateur">Utilisateur :</label>
            <br /><input type="text" class="form-control" id="utilisateur" readonly value="<?php echo $article->getUser()->getLogin(); ?>" />
            <br />
            <label for="datecreation">Date de création :</label>
            <br /><input type="text" class="form-control" id="datecreation" readonly value="<?php echo (new DateTime($article->getDateCreation()))->format('d-m-Y H:i:s'); ?>" />
            <br />
            <label>Version :</label>
            <br /><input type="text" class="form-control" id="version" name="version" value="<?php echo $article->getVersion(); ?>" style="width:50%;" />
            </select>
        </div>
        <div class="form-group">
            <input type="submit" value="Valider" class="btn btn-default">
            <a class="btn btn-default" href="<?php echo $config["siteUrl"]?>Faqs">Annuler</a>
        </div>
        <input type="hidden" name="id" value="<?php echo $article->getId(); ?>" />
    </fieldset>
</form>
