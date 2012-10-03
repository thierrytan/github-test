<?
class Cutilisateur {
    private $login;
    private $password;
    private $email;
    
    function __construct($login, $password, $email) {
        $this->setLogin($login);
        $this->setPassword($password);
        $this->setEmail($email);
    }    
    
    function  __toString() {
        return "Utilisateur (".$this->login.",". $this->password.",". $this->email.")";
    }
    
    function setLogin($login) {$this->login = $login;}
    function setPassword($password) {$this->password = $password;}
    function setEmail($email) {$this->email = $email;}
    
    function getLogin() {return $this->login;}
    function getPassword() {return $this->password;}
    function getEmail() {return $this->email;}
    
    function saveToDB($methode) {
        $user = 'root';
        $password = 'root';
        $dataSourceName = 'mysql:host=localhost;dbname=projet';
        
        try {
            //Connexion à la base            
            $base = new PDO ($dataSourceName, $user, $password);
            
            if ($methode=="update") {
                //Mise à jour du mot de passe ou de l'adresse email
                //Préparation avant entrée dans la base
                $requete = "UPDATE personne SET password = :password, email = :email WHERE login = :login";
            }
            else {
                //Inscription d'un nouvel utilisateur
                //Préparation avant entrée dans la base
                $requete = "INSERT INTO personne VALUES (:login, :password, :email)";
            }
                
            $statement = $base->prepare($requete);
            
            //Paramètre et exécution de la sauvegarde dans la base de données
            $login = $this->getLogin();
            $pass = $this->getPassword();
            $email = $this->getEmail();
            $statement->execute (array(':login' => $login, ":password" => $pass, ":email" => $email));
        }
        catch (PDOException $e) {
            //En cas d'erreur
            echo ("Erreur ! ".$e->getMessage());
        }
        
        //Déconnexion
        $base = NULL;
    }
    
    //Récupérer les infos liées à l'utilisateur connecté
    function getFromDB($login) {
        $user = 'root';
        $password = 'root';
        $dataSourceName = 'mysql:host=localhost;dbname=projet';
        
        try {
            $base = new PDO ($dataSourceName, $user, $password);
            
            //On récupère tous les données associés au login
            $requete = "SELECT * FROM personne WHERE (login = :login)";
            $donnees = $base->prepare($requete);
            $donnees->execute(array(':login' => $login));
            
            $resultat = $donnees->fetch();
            
            if (!$resultat) {
                echo 'Mauvais login';
            }
            else {
                $login = $resultat['login'];
                $password = $resultat['password'];
                $email = $resultat['email'];
                
                //On affecte les données récupérées à l'objet
                $this->setLogin($login);
                $this->setPassword($password);
                $this->setEmail($email);
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