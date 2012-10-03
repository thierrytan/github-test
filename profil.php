<?php
require_once 'modele/Cutilisateur.php';

session_start();
$login = $_SESSION['login'];

require_once 'auth_securite.php';

$user = new Cutilisateur();
$user->getFromDB($login);
$pass = $user->getPassword();

//Controle et modification du mot de passe
if(isset($_POST['pass1'])&&isset($_POST['pass2'])&&isset($_POST['pass3'])&&($_POST['pass2']!="")&&($_POST['pass3']!="")) {
    
    //$user = new Cutilisateur();
    //$user->getFromDB($login);
    
    //On compare les deux nouveaux mots de passe
    if ($_POST['pass2']==$_POST['pass3']) { 
        
        //Hacher les mots de passe
        $newPass = sha1($_POST['pass2']);
        $oldPass = sha1($_POST['pass1']);

        //Controle si on a bien mis l'ancien mot de passe
        if($user->getPassword()==$oldPass) {
            
            //Modification du mot de passe dans l'objet, puis dans la base de donnée
            $user->setPassword($newPass);
            $user->saveToDB("update");

        }
    }
    
}

//Controle et modification de l'adresse email
if(isset($_POST['email'])&&($_POST['email']!="")) {
    
    //$user = new Cutilisateur();
    //$user->getFromDB($login);
    
    $newEmail = $_POST['email'];
    
    //Modification du mot de passe dans l'objet, puis dans la base de donnée
    $user->setEmail($newEmail);
    $user->saveToDB("update");

}

//On récupère tous les infos de l'utilisateur
$user = new Cutilisateur();
$user->getFromDB($login);

include_once 'vue/profil.php';
?>
