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
            echo "<thead><tr><th>Titre</th><th>Statut</th><th>Crée le</th></tr></thead>";
            echo "<tbody>";
            foreach ($objects as $object){
                echo "<tr>";
                echo "<td><a href='" . $config["siteUrl"].$baseHref . "/messages/" . $object->getId() . "'>".$object->getTitre()."</a></td>";
                echo "<td style='width:10%;'>".$object->getStatut()."</td>";
                echo "<td style='width:20%;'>".(new DateTime($object->getDateCreation()))->format('d/m/Y H:i:s')."</td>";
                if(Auth::isAdmin()) {
                    echo "<td class='td-center'><a class='btn btn-primary btn-xs' href='" . $baseHref . "/frm/" . $object->getId() . "'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>" .
                        "<td class='td-center'><a class='btn btn-warning btn-xs' href='" . $baseHref . "/delete/" . $object->getId() . "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
                }
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            if(!Auth::isAdmin())
                echo "<a class='btn btn-primary' href='".$config["siteUrl"].$baseHref."/frm'>Ajouter...</a>";
        }
        else
            $this->messageDisconnected();
    }

    private static function getTypes() {
        return ["incident" => "Incident", "demande" => "Demande"];
    }

	public function messages($id) {
        if(Auth::isAuth()) {
            $ticket = $this->getInstance($id);
            if (empty($ticket))
                $this->messageDanger("Ce ticket n'existe pas.");
            elseif (!Auth::isAdmin() && $ticket->getUser() != Auth::getUser())
                $this->messageDanger("Vous n'avez pas l'autorisation de consulter les messages de ce ticket.");
            else {
                $messages = DAO::getOneToMany($ticket, "messages");
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
        else
            $this->messageDisconnected();
	}

    public function frm($id=NULL) {
        if(Auth::isAuth()) {
            if(!empty($id) && Auth::isAdmin()) {
                $ticket = $this->getInstance($id);
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
                $this->messageNotAdmin();
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
            $this->messageDisconnected();
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

                $this->forward($this->title, "index", "Le nouveau ticket a bien été créé !");
            }
            else
                $this->messageWarning("Vous devez remplir tous les champs pour créer un ticket !");
        }
        else
            $this->messageDisconnected();
    }

    public function edit($id) {
        if(Auth::isAuth() && Auth::isAdmin()) {
            if(!empty($_POST['type']) && !empty($_POST['categorie']) && !empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['statut'])) {
                $ticket = $this->getInstance($id);

                $ticket->setStatut(DAO::getOne("Statut",$_POST['statut']));
                $ticket->setType($_POST['type']);
                $ticket->setCategorie(DAO::getOne("Categorie",$_POST['categorie']));
                $ticket->setTitre($_POST['titre']);
                $ticket->setDescription($_POST['description']);

                DAO::update($ticket);

                $this->forward($this->title, "index", "Le ticket a bien été modifié !");
            }
            else
                $this->messageWarning("Vous devez remplir tous les champs pour éditer ce ticket !");
        }
        else
            $this->messageNotAdmin();
    }
}