<div class="container">
    <a class="btn btn-primary" href="<?php echo $config["siteUrl"]; ?>faqs/article/<?php echo $precedent->getId(); ?>">&lt;&lt; Précédent</a>
    <a class="btn btn-primary" href="<?php echo $config["siteUrl"]; ?>faqs/article/<?php echo $suivant->getId(); ?>">Suivant &gt;&gt;</a>
    <br /><br />
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title"><?php echo $article->getTitre(); ?></div>
        </div>
        <div class="panel-body">
            <?php echo $article->getContenu(); ?>
        </div>
        <div class="panel-footer" style="height: 60px;">
            <div style="float:left;">
                Auteur : <?php echo $article->getUser(); ?>
                <br />Version : <?php echo $article->getVersion(); ?>
            </div>
            <div style="float:right;">
                Date de création : <?php echo (new DateTime($article->getDateCreation()))->format('d/m/Y H:i:s'); ?>
                <br />Nombre de vues : <?php echo $article->getPopularity(); ?>
            </div>
        </div>
    </div>
</div>