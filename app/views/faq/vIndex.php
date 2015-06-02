
<div class="container">
    <div class="btn-group btn-group-justified" role="group" aria-label="Classés par" style="margin-top:10px;">
        <a class="btn btn-default" href="javascript:void(0);" onclick="$('html, body').animate({ scrollTop: $('#categories').offset().top }, 1000);">Par catégories</a>
        <a class="btn btn-default" href="javascript:void(0);" onclick="$('html, body').animate({ scrollTop: $('#populaires').offset().top }, 1000);">Les plus populaires</a>
        <a class="btn btn-default" href="javascript:void(0);" onclick="$('html, body').animate({ scrollTop: $('#recents').offset().top }, 1000);">Les plus récents</a>
    </div>
    <br /><br />
    <div class="panel panel-primary" id="categories">
        <div class="panel-heading">
            <div class="panel-title">Sujets classés par catégories</div>
        </div>
        <div class="panel-body">
            <?php echo $listeSujets; ?>
            <?php if(Auth::isAdmin()) { ?>
                <a class="btn btn-primary" href="<?php echo $config["siteUrl"] . $baseHref; ?>/frm">Ajouter un article</a>
            <?php } ?>
        </div>
    </div>
    <div class="panel panel-primary" id="populaires">
        <div class="panel-heading">
            <div class="panel-title">Sujets les plus populaires</div>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <?php foreach($plusPopulaires as $article) { ?>
                    <tr>
                        <td><a href="<?php echo $config["siteUrl"] . $baseHref . "/article/" . $article->getId(); ?>"><?php echo $article->getTitre(); ?></a></td>
                        <td style="text-align:right;"><?php echo $article->getPopularity(); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="panel panel-primary" id="recents">
        <div class="panel-heading">
            <div class="panel-title">Sujets les plus récents</div>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <?php foreach($plusRecents as $article) { ?>
                    <tr>
                        <td><a href="<?php echo $config["siteUrl"] . $baseHref . "/article/" . $article->getId(); ?>"><?php echo $article->getTitre(); ?></a></td>
                        <td style="text-align:right;"><?php echo (new DateTime($article->getDateCreation()))->format('d/m/Y H:i:s'); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>