<header>
    <section class="clearfix">
        <div style="float:left;"><h2><?php echo $ticket->getTitre(); ?></h2></div>
        <div style="float:right;"><h3><?php echo $ticket->getCategorie()->getLibelle(); ?></h3></div>
    </section>
    <section><?php echo $ticket->getDescription(); ?></section>
    <br />
    <section>
        <small>
            Posté par <?php echo $ticket->getUser(); ?> le <?php echo (new DateTime($ticket->getDateCreation()))->format('d/m/Y à H:i:s'); ?>
            <br /><?php echo $ticket->getStatut(); ?>
        </small>
    </section>
</header>
<hr />
<table class="table table-striped">
    <thead>
        <tr>
            <th>Messages</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($messages as $msg){ ?>
        <tr>
            <td data-content="<?php echo (new DateTime($msg->getDate()))->format('d/m/Y - H:i:s'); ?>" data-container="body" data-toggle="popover" data-placement="bottom">
                <strong><?php echo $msg->getUser(); ?></strong>
                <br /><br />
                <div class="showContenu"><?php echo $msg->getContenu(); ?></div>
                <div style="display: none;" class="editContenu">
                    <form method="post" action="messages/edit/<?php echo $msg->getId(); ?>">
                        <textarea name="contenu" class="form-control"><?php echo $msg->getContenu(); ?></textarea>
                        <br /><br />
                        <input type="submit" class="btn btn-default" value="Modifier le message" />
                    </form>
                </div>
            <?php if($msg->getUser() == $currentUser && $msg == end($messages)) { ?>
                <div style="float:right;">
                    <br />
                    <a class="btn btn-primary btn-xs" href="javascript:void(0);" onclick="console.log($('div').prev('.showContenu:last'));$('div').prev('.showContenu:last').hide();$('div').prev('.editContenu:last').show();" style="width:150px;">Éditer</a>
                    <a class="btn btn-warning btn-xs" href="<?php echo $config["siteUrl"]?>messages/delete/<?php echo $msg->getId(); ?>" style="width:150px;">Supprimer</a>
                </div>
            <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php if($ticket->getStatut()->getId() < 5) { ?>
<hr />
<form method="post" action="Messages/add/<?php echo $ticket->getId(); ?>" style="text-align: center;">
    <textarea name="contenu" class="form-control"></textarea>
    <br /><br />
    <input type="submit" class="btn btn-default" value="Envoyer le message" />
</form>
<?php } ?>