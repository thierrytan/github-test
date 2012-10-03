<?php
require_once 'modele/Cutilisateur.php';

//Récupération des données de l'utilisateur qu'on a sélectionné
$login = $_GET['utilisateur'];
$utilisateur = new Cutilisateur();
$utilisateur->getFromDB($login);

//Préparation connexion à la base de donnéee
$user = 'root';
$password = 'root';
$dataSourceName = 'mysql:host=localhost;dbname=projet';

//Compter le nombre de projets, d'activités associés à l'utilisateur
try {
    $base = new PDO ($dataSourceName, $user, $password);
            
    //On récupère le nombre de projet
    $requete = 'SELECT count(*) FROM projet WHERE login = :login';
    $donnees = $base->prepare($requete);
    $donnees->execute(array(':login' => $login));
            
    $nbProjet = $donnees->fetch();
        
    //On récupère le nombre d'activités
    $requete = 'SELECT count(*) FROM activite WHERE login = :login';
    $donnees = $base->prepare($requete);
    $donnees->execute(array(':login' => $login));
            
    $nbActivite = $donnees->fetch();
    
    //On récupère le nombre de sous-activités
    $requete = 'SELECT count(*) FROM tache WHERE login = :login';
    $donnees = $base->prepare($requete);
    $donnees->execute(array(':login' => $login));
            
    $nbTache = $donnees->fetch();
    
    //On récupère le nombre d'activités ayant des sous-activités
    $requete = 'SELECT DISTINCT(no_activite) FROM tache WHERE login = :login';
    $donnees = $base->prepare($requete);
    $donnees->execute(array(':login' => $login));

    $nbActTa = $donnees->fetch();
    
    //On ne comtpe pas les activités ayant des sous-activités
    $nbTotal = (int)$nbActivite[0] + (int)$nbTache[0] - (int)$nbActTa[0];
}
catch (PDOException $e) {
    //En cas d'erreur
    echo ("Erreur ! ".$e->getMessage());
}

function afficher_activite($login){
    $db=mysql_connect("localhost", "root", "root");
    mysql_select_db("projet",$db);
        $request="SELECT * FROM activite WHERE login = '$login' ORDER BY date ASC";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat=mysql_num_rows($connexion);
        for($compteur=0;$compteur<$resultat;$compteur++){
            $DATA=mysql_fetch_object($connexion);
            $request1="SELECT couleur FROM projet WHERE no_projet='$DATA->no_projet'";
            $connexion1=mysql_query($request1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            $DATA1=mysql_fetch_object($connexion1);
            echo "  <div class='activite' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                        <div class='activite_un'>
                            <div class='centrer_contenu'>
                                <table>
                                    <tr>
                                        
                                        <td width='300px'><a href='activite.php?projet=$DATA->no_projet'> $DATA->titre_act</a></td>
                                        <td width='95px' align='right' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ia_$DATA->no_activite', 'slide'); Effect.toggle('toggle_d_$DATA->no_activite', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td >"; echo substr($DATA->date,8,2)."/".substr($DATA->date,5,2)."/".substr($DATA->date,0,4); echo "</td>
                                    </tr>
                                </table>

                            </div>

                        </div>
                        <div class='activite_deux' style='background-color:$DATA1->couleur;'>
                            <div class='centrer_contenu'>
                                <b>$DATA->etat</b>
                            </div>
                        </div>
                    </div>";
                    echo "<div id='toggle_ia_$DATA->no_activite' style=\"display:none;\" class='info_activite' >";
                    echo "<fieldset><legend>Commentaires</legend>";
                    echo "$DATA->note<br>";
                    echo "</fieldset>";
                    echo "</div>"; 
        }

        /* AFFICHAGE DES TACHES ARRIVANT BIENTOT A ECHEANCE*/
        $request="SELECT * FROM tache WHERE login = '$login' ORDER BY date ASC";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat=mysql_num_rows($connexion);
        for($compteur=0;$compteur<$resultat;$compteur++){
            $DATA=mysql_fetch_object($connexion);
                $request1="SELECT couleur FROM projet WHERE no_projet IN(SELECT no_projet FROM activite WHERE no_activite='$DATA->no_activite')";
                $connexion1=mysql_query($request1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                $DATA1=mysql_fetch_object($connexion1);
            echo "  <div class='tache' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                        <div class='tache_un'>
                            <div class='centrer_contenu'>
                                <table>
                                    <tr>
                                        
                                        <td width='300px'><a href='tache.php?activite=$DATA->no_activite'> $DATA->titre_tache</a></td>
                                        <td width='20px' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_it_$DATA->no_tache', 'slide'); Effect.toggle('toggle_d_$DATA->no_tache', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td >"; echo substr($DATA->date,8,2)."/".substr($DATA->date,5,2)."/".substr($DATA->date,0,4); echo "</td>
                                    </tr>
                                </table>

                            </div>

                        </div>
                        <div class='tache_deux' style='background-color:$DATA1->couleur;'>
                            <div class='centrer_contenu'>
                                <b>$DATA->etat</b>
                            </div>
                        </div>
                    </div>";
                    echo "<div id='toggle_it_$DATA->no_tache' style=\"display:none;\" class='info_tache' >";
                    echo "<fieldset><legend>Commentaires</legend>";
                    echo "$DATA->note<br>";
                    echo "</fieldset>";
                    echo "</div>";
        }

    }

include_once 'vue/admin_utilisateur.php';
?>
