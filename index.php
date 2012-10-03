<?php
require_once 'modele/Cutilisateur.php';

session_start();
//SESSSION
if (isset($_POST['login'])) {
    $login = $_POST['login'];
    $pass = sha1($_POST['password']);
    
    //Vérification identifiants
    $user = 'root';
    $password = 'root';
    $dataSourceName = 'mysql:host=localhost;dbname=projet'; 
    
    try {
            $base = new PDO ($dataSourceName, $user, $password);
            
            //On récupère le mot de passe associé
            $requete = 'SELECT * FROM personne WHERE login = :login AND password = :password';
            $donnees = $base->prepare($requete);
            $donnees->execute(array(':login' => $login, ':password' => $pass));
            
            $resultat = $donnees->fetch();
            
            //On regarde si on trouve quelqu'un avec login et password correspondant
            if (!$resultat) {
                echo 'Mauvais login ou mot de passe';
            }
            else {
                session_start();
                $_SESSION['login'] = $login;
                $connecte = 1;
            }
            
        }
        catch (PDOException $e) {
            //En cas d'erreur
            echo ("Erreur ! ".$e->getMessage());
        }
}

if ($_GET['logout']==1) {
    //$_SESSION['login']="";
    session_destroy();
}

include_once 'vue/index.php';
?>
