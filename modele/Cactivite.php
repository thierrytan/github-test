<?php
class Cactivite {
    private $no_activite;
    private $no_projet;
    private $login;
    private $titre_act;
    private $note;
    private $priorite;
    private $etat;
    
    function __construct($no_projet, $login, $titre_act, $note, $priorite) {
        $this->setNoProjet($no_projet);
        $this->setLogin($login);
        $this->setTitre($titre_act);
        $this->setNote($note);
        $this->setPriorite($priorite);
        $this->setEtat("nf");
    }
    
    function  __toString() {
        return "Activite (".$this->no_activite.",".$this->no_projet.",". $this->login.",". $this->titre_act.",".$this->note.",".$this->priorite.")";
    }

    function setNoActivite($no_activite) {$this->no_activite = $no_activite;}
    function setNoProjet($no_projet) {$this->no_projet = $no_projet;}
    function setLogin($login) {$this->login = $login;}
    function setTitreAct($titre) {$this->titre_act = $titre_act;}
    function setNote($note) {$this->note = $note;}
    function setPriorite($priorite) {$this->priorite = $priorite;}
    function setEtat($etat) {$this->etat = $etat;}
    
    function getNoActivite() {return $this->no_activite;}
    function getNoProjet() {return $this->no_projet;}
    function getLogin() {return $this->login;}
    function getTitreAct() {return $this->titre_act;}
    function getNote() {return $this->note;}
    function getPriorite() {return $this->priorite;}
    function getEtat() {return $this->etat;}
    
    function saveToDB($methode) {
        $user = 'root';
        $password = 'root';
        $dataSourceName = 'mysql:host=localhost;dbname=projet';
        
        try {
            //Connexion à la base            
            $base = new PDO ($dataSourceName, $user, $password);
            
            if ($methode=="update") {
                //Mise a jour de l'activite
                //Preparation
                $requete = "UPDATE activite SET no_projet = :no_projet, titre_act = :titre_act, note = :note, priorite = :priorite, etat = :etat WHERE no_activite = :no_activite AND login = :login AND";
            }
            else {
                //Enregistrement d'une nouvelle activité
                //Préparation
                $requete = "INSERT INTO activite (no_projet, login, titre_act, note, priorite, etat) VALUES (:no_projet, :login, :titre_act, :note, :priorite, :etat)";
            }
            
            $statement = $base->prepare($requete);

            //Paramètre et exécution de la sauvegarde dans la base de données
            $no_activite = $this->getNoActivite();
            $no_projet = $this->getNoProjet();
            $login = $this->getLogin();
            $titre_act = $this->getTitreAct();
            $note = $this->getNote();
            $priorite = $this->getPriorite();
            $etat = $this->getEtat();
            $statement->execute (array("no_activite" => $no_activite, ':no_projet' => $no_projet, ":login" => $login, ":titre_act" => $titre_act, ":note" => $note, ":priorite" => $priorite, ":etat" => $etat));
            
        }
        catch (PDOException $e) {
            //En cas d'erreur
            echo ("Erreur ! ".$e->getMessage());
        }
        
        //Déconnexion
        $base = NULL;
    }
    
    //Récupérer les infos liées à l'activité qu'on aura sélectionné
    //On demande aussi le login pour éviter de récupérer l'activité d'un autre
    function getFromDB($no_activite, $login) {
        $user = 'root';
        $password = 'root';
        $dataSourceName = 'mysql:host=localhost;dbname=projet';
        
        try {
            $base = new PDO ($dataSourceName, $user, $password);
            
            //On récupère tous les données associés au numéro d'activité
            $requete = "SELECT * FROM activite WHERE (no_activite = :no_activite) AND (login = :login)";
            $donnees = $base->prepare($requete);
            $donnees->execute(array(':no_activite' => $no_activite, ":login" => $login));
            
            $resultat = $donnees->fetch();
            
            if (!$resultat) {
                echo 'Mauvais numéro activité ou login';
            }
            else {
                $no_activite = $resultat['no_activite'];
                $no_projet = $resultat['no_projet'];
                $login = $resultat['login'];
                $titre_act = $resultat['titre_act'];
                $note = $resultat['note'];
                $priorite = $resultat['priorite'];
                $etat = $resultat['etat'];
                
                //On affecte les données récupérées à l'objet
                $this->setNoActivite($no_activite);
                $this->setNoProjet($no_projet);
                $this->setLogin($login);
                $this->setTitreAct($titre_act);
                $this->setNote($note);
                $this->setPriorite($priorite);
                $this->setEtat($etat);
            }            
            
        }
        catch (PDOException $e) {
            //En cas d'erreur
            echo ("Erreur ! ".$e->getMessage());
        }
        
        $base = NULL;
    }
    
}


?>
