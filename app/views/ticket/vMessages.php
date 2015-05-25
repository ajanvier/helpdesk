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
                <?php echo $msg->getContenu(); ?>
            <?php if($msg->getUser() == $currentUser) { ?>
                <div style="float:right;">
                    <br />
                    <a class="btn btn-primary btn-xs" href="<?php echo $config["siteUrl"]?>messages/edit/<?php echo $msg->getId(); ?>" style="width:150px;">Éditer</a>
                    <a class="btn btn-warning btn-xs" href="<?php echo $config["siteUrl"]?>messages/delete/<?php echo $msg->getId(); ?>" style="width:150px;">Supprimer</a>
                </div>
            <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>