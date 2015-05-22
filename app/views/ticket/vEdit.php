<form method="post" action="Tickets/edit/<?php echo $ticket->getId(); ?>">
    <fieldset>
        <legend>Modifier un ticket</legend>
        <div class="form-group">
            <select name="type" class="form-control">
                <option disabled>Type</option>
                <option disabled>---</option>
                <?php foreach($ticketTypes as $type => $libelle) {  ?>
                    <option value="<?php echo $type; ?>"<?php echo ($type == $ticket->getType()) ? " selected" : ""; ?>><?php echo $libelle; ?></option>
                <?php } ?>
            </select>
            <br />
            <select name="categorie" class="form-control">
                <option disabled selected>Catégorie</option>
                <option disabled>---</option>
                <?php foreach($categories as $cat) {  ?>
                    <option value="<?php echo $cat->getId(); ?>"<?php echo ($cat->getId() == $ticket->getCategorie()->getId()) ? " selected" : ""; ?>><?php echo $cat; ?></option>
                <?php } ?>
            </select>
            <br />
            <label for="titre">Titre :</label>
            <br /><input type="text" class="form-control" id="titre" name="titre" value="<?php echo $ticket->getTitre(); ?>" />
            <br />
            <label for="description">Description :</label>
            <br />
            <textarea id="description" class="form-control" name="description"><?php echo $ticket->getDescription(); ?></textarea>
        </div>
        <div class="form-group">
            <label for="utilisateur">Utilisateur :</label>
            <br /><input type="text" class="form-control" id="utilisateur" name="utilisateur" readonly value="<?php echo $ticket->getUser()->getLogin(); ?>" />
            <br />
            <label for="datecreation">Date de création :</label>
            <br /><input type="text" class="form-control" id="datecreation" name="datecreation" readonly value="<?php echo (new DateTime($ticket->getDateCreation()))->format('d-m-Y H:i:s'); ?>" />
            <br />
            <label>Statut :</label>
            <br />
            <?php foreach($statuts as $statut) {  ?>
                <input type="radio" name="statut" value="<?php echo $statut->getId(); ?>"<?php echo ($statut->getId() == $ticket->getStatut()->getId()) ? " checked" : ""; ?> id="statut<?php echo $statut->getId(); ?>"> <label for="statut<?php echo $statut->getId(); ?>" style="margin-right:10px;"><?php echo $statut; ?></label>
            <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" value="Valider" class="btn btn-default">
            <a class="btn btn-default" href="<?php echo $config["siteUrl"]?>Tickets">Annuler</a>
        </div>
    </fieldset>
</form>
