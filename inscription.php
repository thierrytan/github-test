<?php
require_once 'modele/Cutilisateur.php';

//Si on vient de remplir le formulaire d'inscription
if (isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = sha1($_POST['password']);
    $email = $_POST['email'];
    $newUser = new Cutilisateur($login,$password ,$email );
    $newUser->saveToDB();
 
    //On indique à la vue d'afficher le message de confirmation et de masquer le formulaire
    $confirm = 1;
}
else {
    //On affiche le formulaire d'inscription
    $confirm = 0;
}

include_once 'vue/inscription.php';
?>
