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
        global $config;
        $baseHref = get_class($this);
        if (isset($message)) {
            if (is_string($message)) {
                $message = new DisplayedMessage($message);
            }
            $message->setTimerInterval($this->messageTimerInterval);
            $this->_showDisplayedMessage($message);
        }
        $categories = DAO::getAll("Categorie");
        foreach($categories as $categorie) {
            $objects = DAO::getAll($this->model, "idCategorie=" . $categorie->getId());
            if(!empty($objects)) {
                echo "<table class='table table-striped'>";
                echo "<thead><tr><th>" . $categorie . "</th></tr></thead>";
                echo "<tbody>";
                foreach ($objects as $object) {
                    echo "<tr>";
                    echo "<td><a href='" . $config["siteUrl"] . $baseHref . "/article/" . $object->getId() . "'>" . $object->getTitre() . "</a></td>";
                    if (Auth::isAdmin()) {
                        echo "<td class='td-center'><a class='btn btn-primary btn-xs' href='" . $baseHref . "/frm/" . $object->getId() . "'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>" .
                            "<td class='td-center'><a class='btn btn-warning btn-xs' href='" . $baseHref . "/delete/" . $object->getId() . "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
        }
        if(Auth::isAdmin())
            echo "<a class='btn btn-primary' href='" . $config["siteUrl"] . $baseHref . "/frm'>Ajouter...</a>";
    }

    public function article($id=null) {

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