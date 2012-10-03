<?php
require_once 'modele/Cutilisateur.php';

$user = 'root';
$password = 'root';
$dataSourceName = 'mysql:host=localhost;dbname=projet';

try {
    $base = new PDO ($dataSourceName, $user, $password);
            
    //On récupère tous les login utilisateurs
    $requete = "SELECT login FROM personne";
    $donnees = $base->prepare($requete);
    $donnees->execute();
    
    $base = NULL;
   
    //Création d'une liste qui contiendra tous les utilisateurs sous forme d'objet
    $listeUtilisateur = array();
    
    //Pour chaque login récupéré, on ajoutera dans la liste un objet correspondant au login
    while ($resultat = $donnees->fetch()) {       
        //Récupération des données de chaque utilisateur
        $utilisateur = new Cutilisateur();
        $utilisateur->getFromDB($resultat['login']);
        //Ajout de l'objet Utilisateur dans la liste
        array_push($listeUtilisateur,$utilisateur);
    }
              
}
catch (PDOException $e) {
    //En cas d'erreur
    echo ("Erreur ! ".$e->getMessage());
}
        

include_once 'vue/admin.php';
?>
