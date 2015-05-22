<header>
    <section class="clearfix">
        <div style="float:left;"><h2><?php echo $ticket->getTitre(); ?></h2></div>
        <div style="float:right;"><h3><?php echo $ticket->getCategorie()->getLibelle(); ?> - <?php echo $ticket->getStatut()->getLibelle(); ?></h3></div>
    </section>
    <section><?php echo $ticket->getDescription(); ?></section>
    <br />
    <section>
        <small>Posté par <?php echo $ticket->getUser(); ?> le <?php echo (new DateTime($ticket->getDateCreation()))->format('d/m/Y à H:i:s'); ?>
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
            <td title="message" data-content="<?php echo htmlentities($msg->getContenu()); ?>" data-container="body" data-toggle="popover" data-placement="bottom"><?php echo $msg->toString(); ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>