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

    public function index($message=null){
        if(Auth::isAuth()) {
            global $config;
            $baseHref=get_class($this);
            if(isset($message)){
                if(is_string($message)){
                    $message=new DisplayedMessage($message);
                }
                $message->setTimerInterval($this->messageTimerInterval);
                $this->_showDisplayedMessage($message);
            }
            $objects = DAO::getAll($this->model, (Auth::isAdmin()) ? "" : "idUser=" . Auth::getUser()->getId());

            echo "<table class='table table-striped'>";
            echo "<thead><tr><th>".$this->model."</th></tr></thead>";
            echo "<tbody>";
            foreach ($objects as $object){
                echo "<tr>";
                echo "<td><a href='" . $config["siteUrl"].$baseHref . "/messages/" . $object->getId() . "'>".$object->toString()."</a></td>";
                if(Auth::isAdmin()) {
                    echo "<td class='td-center'><a class='btn btn-primary btn-xs' href='" . $baseHref . "/frm/" . $object->getId() . "'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>" .
                        "<td class='td-center'><a class='btn btn-warning btn-xs' href='" . $baseHref . "/delete/" . $object->getId() . "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
                }
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<a class='btn btn-primary' href='".$config["siteUrl"].$baseHref."/frm'>Ajouter...</a>";
        }
    }

    private static function getTypes() {
        return ["incident" => "Incident", "demande" => "Demande"];
    }

	public function messages($id) {
		$ticket=DAO::getOne($this->model, $id[0]);
        if(empty($ticket))
            $this->messageDanger("Ce ticket n'existe pas.");
        elseif(!Auth::isAdmin() && $ticket->getUser() != Auth::getUser())
            $this->messageDanger("Vous n'avez pas l'autorisation de consulter les messages de ce ticket.");
        else {
			$messages=DAO::getOneToMany($ticket, "messages");
            $this->loadView("ticket/vMessages", array(
                "ticket" => $ticket,
                "messages" => $messages,
                "currentUser" => Auth::getUser()
            ));

			echo JsUtils::execute("$(function () {
					  $('[data-toggle=\"popover\"]').popover({'trigger':'hover','html':true})
				})");
        }

	}

    public function frm($id=NULL) {
        if(Auth::isAuth()) {
            if(!empty($id) && Auth::isAdmin()) {
                $ticket = DAO::getOne($this->model, $id[0]);
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
                $ticket = DAO::getOne($this->model, $id[0]);

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