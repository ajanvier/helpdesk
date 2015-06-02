<div class="container">
    <table class="table">
        <tr>
            <th>Mes tickets</th>
            <th style="width:10%;">Nombre</th>
        </tr>
        <tr>
            <td>Nouveau</td>
            <td><?php echo $nbTickets['nouveau']; ?></td>
        </tr>
        <tr class="active">
            <td>Attribué</td>
            <td><?php echo $nbTickets['attribue']; ?></td>
        </tr>
        <tr class="success">
            <td>Résolu</td>
            <td><?php echo $nbTickets['resolu']; ?></td>
        </tr>
    </table>
    <br />
    <a class="btn btn-default" href="tickets/frm" role="button" style="width:200px;">Créer un ticket</a>
    <br /><br />
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title"><h3>Base de connaissances : Sujets les plus récents</h3></div>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <?php foreach($articles as $article) { ?>
                <tr>
                    <td><a href="faqs/article/<?php echo $article->getId(); ?>"><?php echo $article->getTitre(); ?></a></td>
                    <td style="float:right;"><?php echo (new DateTime($article->getDateCreation()))->format('d/m/Y H:i:s'); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>