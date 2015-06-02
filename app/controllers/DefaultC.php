<?php
/**
 * Contrôleur par défaut (défini dans config => documentRoot)
 * @author jcheron
 * @version 1.1
 * @package helpdesk.controllers
 */
class DefaultC extends \BaseController {

	/**
	 * Affiche la page par défaut du site
	 * @see BaseController::index()
	 */
	public function index() {
		$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
        echo "<div class='container'>";

        if(Auth::isAdmin())
		    $this->loadView("main/vAdmin");
        elseif(Auth::isAuth()) {
            $currentUser = Auth::getUser();
            $this->loadView("main/vUser", array(
                "nbTickets" => [
                    "nouveau" => count(DAO::getAll("Ticket", "idUser=" . $currentUser->getId() . " and idStatut=1")),
                    "attribue" => count(DAO::getAll("Ticket", "idUser=" . $currentUser->getId() . " and idStatut=2")),
                    "resolu" => count(DAO::getAll("Ticket", "idUser=" . $currentUser->getId() . " and idStatut=4"))
                ],
                "articles" => DAO::getAll("FAQ","1 order by dateCreation DESC LIMIT 3")
            ));
        }
        else
            $this->messageInfo("Vous devez être connecté pour accéder à cette page.",0,false);

        echo "</div>";
		$this->loadView("main/vFooter");
	}

	/**
	 * Affiche la page de test
	 */
	public function test() {
		$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
		$this->loadView("main/vTest");
		$this->loadView("main/vFooter");
	}
	/**
	 * Connecte le premier administrateur trouvé dans la BDD
	 */
	public function asAdmin(){
		$_SESSION["user"]=DAO::getOne("User", "admin=1");
		$_SESSION['KCFINDER'] = array(
				'disabled' => false
		);
		$this->index();
	}

	/**
	 * Connecte le premier utilisateur (non admin) trouvé dans la BDD
	 */
	public function asUser($id=null){
		$_SESSION["user"]=DAO::getOne("User", "admin=0" . ((!empty($id)) ? " and id=" . $id[0] : ""));
		$_SESSION['KCFINDER'] = array(
				'disabled' => true
		);
		$this->index();
	}

	/**
	 * Déconnecte l'utilisateur actuel
	 */
	public function disconnect(){
		$_SESSION = array();
		$_SESSION['KCFINDER'] = array(
				'disabled' => true
		);
		$this->index();
	}

	public function ckEditorSample(){
		$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
		echo "<div class='container'>";
		echo "<h1>Exemple ckEditor</h1>";
		echo "<textarea id='editor1'>Exemple de <strong>contenu</strong></textarea>";
		echo JsUtils::execute("CKEDITOR.replace( 'editor1');");
		echo "</div>";
		$this->loadView("main/vFooter");
	}

}