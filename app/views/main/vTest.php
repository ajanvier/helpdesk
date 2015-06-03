<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                Module de reports d'incidents (Tickets)
            </div>
        </div>
        <div class="panel-body">
            <a class="btn btn-primary" href="<?php echo $config['siteUrl']; ?>tickets">Consulter les tickets</a>
            <?php if(!Auth::isAdmin()) { ?>
            <a class="btn btn-primary" href="<?php echo $config['siteUrl']; ?>tickets/frm">Ajouter un ticket</a>
            <?php } else { ?>
            <a class="btn btn-primary" href="<?php echo $config['siteUrl']; ?>tickets/frm/3">Editer le ticket n°3</a>
            <?php } ?>
            <a class="btn btn-primary" href="<?php echo $config['siteUrl']; ?>tickets/messages/3">Consulter le ticket n°3</a>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                Module Base de connaissances (FAQ)
            </div>
        </div>
        <div class="panel-body">
            <a class="btn btn-info" href="<?php echo $config['siteUrl']; ?>faqs">Consulter les articles</a>
            <?php if(Auth::isAdmin()) { ?>
                <a class="btn btn-info" href="<?php echo $config['siteUrl']; ?>faqs/frm">Ajouter un article</a>
                <a class="btn btn-info" href="<?php echo $config['siteUrl']; ?>faqs/frm/3">Editer l'article n°3</a>
            <?php } ?>
            <a class="btn btn-info" href="<?php echo $config['siteUrl']; ?>faqs/article/3">Consulter l'article n°3</a>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                Module commun
            </div>
        </div>
        <div class="panel-body">
            <a class="btn btn-default" href="<?php echo $config['siteUrl']; ?>"><?php echo (Auth::isAdmin()) ? "Accueil Administrateur" : "Accueil Utilisateur"; ?></a>
        </div>
    </div>
</div>