<?php
class Cprojet {
    private $no_projet;
    private $login;
    private $titre_proj;
    private $note;
    private $date;
    private $couleur;
    private $etat;
    
    function __construct($login, $titre_proj, $note, $date, $couleur) {        
        $this->setLogin($login);
        $this->setTitreProj($titre_proj);
        $this->setNote($note);
        $this->setDate($date);
        $this->setCouleur($couleur);
        $this->setEtat("nf");
    }
    
    function  __toString() {
        return "Projet (".$this->no_projet.",". $this->login.",". $this->titre_proj.",".$this->note.",".$this->date.",".$this->couleur.")";
    }
    
    function setNoProjet($no_projet) {$this->no_projet = $no_projet;}
    function setLogin($login) {$this->login = $login;}
    function setTitreProj($titre_proj) {$this->titre_proj = $titre_proj;}
    function setNote($note) {$this->note = $note;}
    function setDate($date) {$this->date = $date;}
    function setCouleur($couleur) {$this->couleur = $couleur;}
    function setEtat($etat) {$this->etat = $etat;}
    
    function getNoProjet() {return $this->no_projet;}
    function getLogin() {return $this->login;}
    function getTitreAct() {return $this->titre_proj;}
    function getNote() {return $this->note;}
    function getDate() {return $this->date;}
    function getCouleur() {return $this->couleur;}
    function getEtat() {return $this->etat;}
    
    function saveToDB($requete) {
        $user = 'root';
        $password = 'root';
        $dataSourceName = 'mysql:host=localhost;dbname=projet';
        
        try {
            //Connexion à la base            
            $base = new PDO ($dataSourceName, $user, $password);
            
            if($requete == "update") {
                //Mise a jour d'un projet
                //Préparation avant entrée dans la base
                $requete = "UPDATE projet SET titre_proj = :titre_proj, note = :note, date = :date, couleur = :couleur, etat = :etat WHERE no_projet = :no_projet AND login = :login";
            }
            else {
                //Enregistrement d'un nouveau projet
                //Préparation avant entrée dans la base
                $requete = "INSERT INTO projet (login, titre_proj, note, date, couleur, etat) VALUES (:login, :titre_proj, :note, :date, :couleur, :etat)";             
            }
            
            $statement = $base->prepare($requete);
            
            //Paramètre et exécution de la sauvegarde dans la base de données
            $no_projet = $this->getNoProjet();
            $login = $this->getLogin();
            $titre_proj = $this->getTitreProj();
            $note = $this->getNote();
            $date = $this->getDate();
            $couleur = $this->getCouleur();
            $etat = $this->getEtat();
            $statement->execute (array(":no_projet" => $no_projet, ":login" => $login, ":titre_proj" => $titre_proj, ":note" => $note, ":date" => $date, ":couleur" => $couleur, ":etat" => $etat));
        }
        catch (PDOException $e) {
            //En cas d'erreur
            echo ("Erreur ! ".$e->getMessage());
        }
        
        //Déconnexion
        $base = NULL;
    }
    
    //Récupérer les infos liées au projet qu'on aura sélectionné
    //On demande aussi le login pour éviter de récupérer le projet d'un autre
    function getFromDB($no_projet, $login) {
        $user = 'root';
        $password = 'root';
        $dataSourceName = 'mysql:host=localhost;dbname=projet';
        
        try {
            $base = new PDO ($dataSourceName, $user, $password);
            
            //On récupère tous les données associés au numéro d'activité
            $requete = "SELECT * FROM projet WHERE (no_projet = :no_projet, login = :login)";
            $donnees = $base->prepare($requete);
            $donnees->execute(array(':no_activite' => $no_activite, "login" => $login));
            
            $resultat = $donnees->fetch();
            
            if (!$resultat) {
                echo 'Mauvais numéro projet ou login';
            }
            else {
                $no_projet = $resultat['no_projet'];
                $login = $resultat['login'];
                $titre_proj = $resultat['titre_proj'];
                $note = $resultat['note'];
                $date = $requete['date'];
                $couleur = $resultat['couleur'];
                $etat = $resultat['etat'];
                
                //On affecte les données récupérées à l'objet
                $this->setNoProjet($no_projet);
                $this->setLogin($login);
                $this->setTitreProj($titre_proj);
                $this->setNote($note);
                $this->setDate($date);
                $this->setCouleur($couleur);
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
