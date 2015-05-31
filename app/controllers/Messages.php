<?php
/**
 * Gestion des messages
 * @author jcheron
 * @version 1.1
 * @package helpdesk.controllers
 */
class Messages extends \_DefaultController {
	public function Messages(){
		parent::__construct();
		$this->title="Tickets";
		$this->model="Message";
	}

    public function delete($id) {
        global $config;

        $object=DAO::getOne($this->model, $id[0]);
        if(empty($object))
            $this->messageDanger("Ce message n'existe pas.");
        elseif(!Auth::isAdmin() && $object->getUser() != Auth::getUser())
            $this->messageDanger("Vous n'avez pas l'autorisation de supprimer ce message.");
        else {
            try{
                if($object!==NULL){
                    DAO::delete($object);
                    $msg=new DisplayedMessage($this->model." `{$object->toString()}` supprimé(e)");
                }else{
                    $msg=new DisplayedMessage($this->model." introuvable","warning");
                }
            }catch(Exception $e){
                $msg=new DisplayedMessage("Impossible de supprimer l'instance de ".$this->model,"danger");
            }
            $this->forward("Tickets", "messages", $object->getTicket()->getId());
        }
    }
}