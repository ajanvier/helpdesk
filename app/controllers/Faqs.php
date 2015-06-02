<?php
/**
 * Gestion des articles de la Faq
 * @author jcheron
 * @version 1.1
 * @package helpdesk.controllers
 */
class Faqs extends \_DefaultController {
	public function Faqs(){
		parent::__construct();
		$this->title="Foire aux questions";
		$this->model="Faq";
	}

    public function index() {
        if(Auth::isAuth()) {
            global $config;
            $baseHref = get_class($this);
            if (isset($message)) {
                if (is_string($message)) {
                    $message = new DisplayedMessage($message);
                }
                $message->setTimerInterval($this->messageTimerInterval);
                $this->_showDisplayedMessage($message);
            }

            $listeSujets = "";
            $categories = DAO::getAll("Categorie");
            foreach ($categories as $categorie) {
                $objects = DAO::getAll($this->model, "idCategorie=" . $categorie->getId());
                if (!empty($objects)) {
                    $listeSujets .= "<table class='table table-striped'>";
                    $listeSujets .= "<thead><tr><th>" . $categorie . "</th></tr></thead>";
                    $listeSujets .= "<tbody>";
                    foreach ($objects as $object) {
                        $listeSujets .= "<tr>";
                        $listeSujets .= "<td><a href='" . $config["siteUrl"] . $baseHref . "/article/" . $object->getId() . "'>" . $object->getTitre() . "</a></td>";
                        if (Auth::isAdmin()) {
                            $listeSujets .= "<td class='td-center'><a class='btn btn-primary btn-xs' href='" . $baseHref . "/frm/" . $object->getId() . "'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>" .
                                "<td class='td-center'><a class='btn btn-warning btn-xs' href='" . $baseHref . "/delete/" . $object->getId() . "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
                        }
                        $listeSujets .= "</tr>";
                    }
                    $listeSujets .= "</tbody>";
                    $listeSujets .= "</table>";
                }
            }

            $this->loadView("faq/vIndex", array(
                "listeSujets" => $listeSujets,
                "plusPopulaires" => DAO::getAll("FAQ", "1 order by popularity DESC LIMIT 10"),
                "plusRecents" => DAO::getAll("FAQ", "1 order by dateCreation DESC LIMIT 10"),
                "baseHref" => $baseHref
            ));
        }
        else
            $this->messageDisconnected();
    }

    public function article($id=null) {
        if(Auth::isAuth()) {
            $article = DAO::getOne($this->model, $id[0]);
            if (empty($article))
                $this->messageDanger("Cet article n'existe pas.");
            else {
                $precedent = DAO::getAll($this->model, "id<" . $article->getId() . " order by id desc limit 1");
                if(empty($precedent))
                    $precedent = DAO::getAll($this->model, "1 order by id desc limit 1")[0];
                else
                    $precedent = $precedent[0];

                $suivant = DAO::getAll($this->model, "id>" . $article->getId() . " order by id asc limit 1");
                if(empty($suivant))
                    $suivant = DAO::getAll($this->model, "1 order by id limit 1")[0];
                else
                    $suivant = $suivant[0];

                $article->setPopularity($article->getPopularity()+1);
                DAO::update($article);

                $this->loadView("faq/vArticle", array(
                    "article" => $article,
                    "precedent" => $precedent,
                    "suivant" => $suivant
                ));
            }
        }
        else
            $this->messageDisconnected();
    }

    public function frm($id=null) {

    }

	/* (non-PHPdoc)
	 * @see _DefaultController::setValuesToObject()
	 */
	protected function setValuesToObject(&$object) {
		parent::setValuesToObject($object);
		$object->setUser(Auth::getUser());
		$categorie=DAO::getOne("Categorie", $_POST["idCategorie"]);
		$object->setCategorie($categorie);
	}
}