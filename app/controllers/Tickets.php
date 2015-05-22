<?php
/**
 * Gestion des tickets
 * @author jcheron
 * @version 1.1
 * @package helpdesk.controllers
 */

class Tickets extends \_DefaultController {

	public function Tickets(){
		$this->title="Tickets";
		$this->model="Ticket";
	}

    private static function getTypes() {
        return ["incident" => "Incident", "demande" => "Demande"];
    }

	public function messages($id){
		$ticket=DAO::getOne("Ticket", $id[0]);
		if($ticket!=NULL){
			echo "<h2>".$ticket."</h2>";
			$messages=DAO::getOneToMany($ticket, "messages");
			echo "<table class='table table-striped'>";
			echo "<thead><tr><th>Messages</th></tr></thead>";
			echo "<tbody>";
			foreach ($messages as $msg){
				echo "<tr>";
				echo "<td title='message' data-content='".htmlentities($msg->getContenu())."' data-container='body' data-toggle='popover' data-placement='bottom'>".$msg->toString()."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			echo JsUtils::execute("$(function () {
					  $('[data-toggle=\"popover\"]').popover({'trigger':'hover','html':true})
				})");
		}
	}

    public function frm($id=NULL) {
        if(Auth::isAuth()) {
            if(!empty($id) && Auth::isAdmin()) {
                $ticket = DAO::getOne("Ticket", $id[0]);
                $categories = DAO::getAll("Categorie");
                $statuts = DAO::getAll("Statut");

                $this->loadView("ticket/vEdit", array(
                    "ticketTypes" => Tickets::getTypes(),
                    "categories" => $categories,
                    "ticket" => $ticket,
                    "statuts" => $statuts
                ));
            }
            elseif(!empty($id) && !Auth::isAdmin()) {
                $this->messageDanger("Vous devez être administrateur pour accéder à cette page.");
            }
            else {
                $categories = DAO::getAll("Categorie");
                $this->loadView("ticket/vAdd", array(
                    "ticketTypes" => Tickets::getTypes(),
                    "categories" => $categories,
                    "currentUser" => Auth::getUser()
                ));
            }
        }
        else
            $this->messageDanger("Vous devez être connecté pour accéder à cette page.");
    }

    public function add($id=NULL) {
        if(Auth::isAuth()) {
            if(!empty($_POST['type']) && !empty($_POST['categorie']) && !empty($_POST['titre']) && !empty($_POST['description'])) {
                $ticket = new Ticket();
                $ticket->setUser(Auth::getUser());
                $ticket->setStatut(DAO::getOne("Statut",1));
                if(in_array($_POST['type'], Tickets::getTypes())) {
                    $ticket->setType($_POST['type']);
                }
                $ticket->setCategorie(DAO::getOne("Categorie",$_POST['categorie']));
                $ticket->setTitre($_POST['titre']);
                $ticket->setDescription($_POST['description']);

                DAO::insert($ticket);

                $this->messageSuccess("Le nouveau ticket a bien été crée !");
            }
            else
                $this->messageWarning("Vous devez remplir tous les champs pour créer un ticket !");
        }
        else
            $this->messageDanger("Vous devez être connecté pour accéder à cette page.");
    }

    public function edit($id) {
        if(Auth::isAuth() && Auth::isAdmin()) {
            if(!empty($_POST['type']) && !empty($_POST['categorie']) && !empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['statut'])) {
                $ticket = DAO::getOne("Ticket", $id[0]);

                $ticket->setStatut(DAO::getOne("Statut",$_POST['statut']));
                $ticket->setType($_POST['type']);
                $ticket->setCategorie(DAO::getOne("Categorie",$_POST['categorie']));
                $ticket->setTitre($_POST['titre']);
                $ticket->setDescription($_POST['description']);

                DAO::update($ticket);

                $this->messageSuccess("Le ticket a bien été modifié !");
            }
            else
                $this->messageWarning("Vous devez remplir tous les champs pour éditer ce ticket !");
        }
        else
            $this->messageDanger("Vous devez être administrateur pour accéder à cette page.");
    }
}