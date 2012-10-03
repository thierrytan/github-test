<?php

session_start();
require_once 'auth_securite.php';


$db=mysql_connect("localhost", "root", "root");
mysql_select_db("projet",$db);

$login = $_SESSION['login'];
$_SESSION['activite']=$_GET['activite'];

function formulaire_cache_ajout_tache() {
    echo "<div id='toggle_new' style=\"display:none;\" class='maj_tache' >";
    echo "<form action='action.php?source=tache&operation=creer' method='post'>";
    echo "<input type='hidden' name='no_activite_courante' value='" . $_SESSION['activite'] . "'>";
    echo "T&acirc;che : <input type='text' name='titre_tache'>";
    echo "<hr>";
    echo "<textarea name='note' rows='2' cols='63'></textarea><br>";
    echo "Priorit&eacute; : ";
    echo "<select name='priorite'>";
    echo "<option value='1'>Forte</option>";
    echo "<option value='2'>Moyenne</option>";
    echo "<option value='3'>Faible</option>";
    echo "</select>";
    echo " Etat : ";
    echo "<select name='etat'>";
    echo "<option value='A faire'>A faire</option>";
    echo "<option value='Fait'>Fait</option>";
    echo "</select>";
    echo " Date : ";
    echo "<select name='jour'>";
    for ($x = 1; $x < 32; $x++) {
        if (strlen($x) == 1) {
            echo "<option value='0$x'>0$x</option>";
        }
        if (strlen($x) == 2) {
            echo "<option value='$x'>$x</option>";
        }
    }
    echo "</select>";
    echo " ";

    echo "<select name='mois'>";
    echo "<option value='01'>janvier</option>";
    echo "<option value='02'>f&eacute;vrier</option>";
    echo "<option value='03'>mars</option>";
    echo "<option value='04'>avril</option>";
    echo "<option value='05'>mai</option>";
    echo "<option value='06'>juin</option>";
    echo "<option value='07'>juiller</option>";
    echo "<option value='08'>aout</option>";
    echo "<option value='09'>septembre</option>";
    echo "<option value='10'>octobre</option>";
    echo "<option value='11'>novembre</option>";
    echo "<option value='12'>d&eacute;cembre</option>";
    echo "</select>";
    echo " ";
    echo "<select name='annee'>";
    for ($y = 2010; $y < 2021; $y++) {
        echo "<option value='$y'>$y</option>";
    }

    echo "</select><br>";
    echo "<input type='submit' value='Cr&eacute;er cette t&acirc;che'>";
    echo "</form>";
    echo "</div>";
}

function afficher_tache(){

        formulaire_cache_ajout_tache();

        /*Récupération des informations sur le projet courant*/
        $request_proj="SELECT * FROM projet WHERE no_projet IN(SELECT no_projet FROM activite WHERE no_activite='".$_SESSION['activite']."' AND login='".$_SESSION['login']."')";
        $connexion_proj = mysql_query($request_proj);
        $DATA_PROJ = mysql_fetch_object($connexion_proj);

        /*Récupération des informations sur l'activité courante*/
        $request_act="SELECT * FROM activite WHERE login='".$_SESSION['login']."' AND no_projet='$DATA_PROJ->no_projet'";
        $connexion_act=mysql_query($request_act) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $DATA_ACT=mysql_fetch_object($connexion_act);

        /*Récupération des informations des taches*/
        $request="SELECT * FROM tache WHERE login='".$_SESSION['login']."' AND no_activite='".$_SESSION['activite']."'";
        $connexion = mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat = mysql_num_rows($connexion);

        /*Affichage du projet courant*/
        echo "  <div class='projet' style='background-color:$DATA_PROJ->couleur;'>
                    <div class='projet_un'>
                        <div class='centrer_contenu'>
                            Projet : <a href='activite.php?projet=$DATA_PROJ->no_projet'>$DATA_PROJ->titre_proj</a>
                        </div>
                    </div>
                    <div class='projet_deux' style='background-color:$DATA_PROJ->couleur;'>
                        <div class='centrer_contenu'>

                        </div>
                    </div>
                </div>";

        /*Affichage de l'activité courante*/
        echo "  <div class='activite' style='background-color:$DATA_PROJ->couleur;'>
                    <div class='activite_un'>
                        <div class='centrer_contenu'>
                            Activit&eacute; : ".$DATA_ACT->titre_act."
                        </div>
                    </div>
                    <div class='activite_deux' style='background-color:$DATA_PROJ->couleur;'>
                        <div class='centrer_contenu'>

                        </div>
                    </div>
                </div>";

        /*Affichage des taches concernés*/
        for($compteur=0;$compteur<$resultat;$compteur++){
            $DATA=mysql_fetch_object($connexion);
            echo "<div class='tache' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                    <div class='tache_un'>
                        <div class='centrer_contenu'>
                            <table>
                                <tr>
                                    <td><input id='$DATA->no_tache' type='checkbox' name='tache' value='$DATA->no_tache' onclick='test(this.value)'></td>
                                    <td width='300px'>t&acirc;che : $DATA->titre_tache</td>
                                    <td width='20px'><a href=\"#\" onclick=\"Effect.toggle('toggle_i_$DATA->no_tache', 'slide'); Effect.toggle('toggle_d_$DATA->no_tache', 'appear');return false;\"><i>Informations</i></a></td>
                                    <td><a href=\"#\" onclick=\"Effect.toggle('toggle_$DATA->no_tache', 'appear'); return false;\"><i>Update</i></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class='tache_deux' style='background-color:$DATA_PROJ->couleur;'>
                        <div class='centrer_contenu'>
                            <div id='toggle_d_$DATA->no_tache' style=\"display:none;text-align:center;\"><u>";
                            echo substr($DATA->date,8,2)."/";
                            echo substr($DATA->date,5,2)."/";
                            echo substr($DATA->date,0,4);
                            echo "</u></div>
                        </div>
                    </div>
                </div>";


                    echo "<div id='toggle_i_$DATA->no_tache' style=\"display:none;\" class='info_tache' >";
                    echo "<fieldset><legend>Commentaires</legend>";
                    echo "$DATA->note<br>";
                    echo "</fieldset>";
                    echo "</div>";


            echo "<div id='toggle_$DATA->no_tache' style=\"display:none;\" class='maj_tache' >";
                    echo "<form action='action.php?source=tache&operation=modification' method='post'>";
                    echo "<input type='hidden' name='no_tache' value='$DATA->no_tache'>";
                    echo "<input type='hidden' name='no_activite_courante' value='$DATA->no_activite'>";
                        echo "T&acirc;che : <input type='text' name='titre_tache' value='".str_replace("'", "&#039;", $DATA->titre_tache)."'>";
                        echo " dans l'Activit&eacute; ";
                            echo "<select name='no_activite'>";

                                $request4="SELECT * FROM activite WHERE no_projet='$DATA_PROJ->no_projet'";
                                $connexion4=mysql_query($request4) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                                $resultat4=mysql_num_rows($connexion4);
                                for($j=0;$j<$resultat4;$j++){
                                    $DATA4=mysql_fetch_object($connexion4);
                                    echo "<option "; if($DATA4->no_activite==$DATA->no_activite)  echo 'selected'; echo " value='$DATA4->no_activite'>$DATA4->titre_act</option>";
                                }
                            echo "</select>";
                            echo "<hr>";
                            echo "<textarea name='note' rows='2' cols='63'>$DATA->note</textarea><br>";
                            echo "Priorit&eacute; : ";
                                echo "<select name='priorite'>";
                                    echo "<option "; if($DATA->priorite=='1') echo ' selected '; echo "value='1'>Forte</option>";
                                    echo "<option "; if($DATA->priorite=='2') echo ' selected '; echo "value='2'>Moyenne</option>";
                                    echo "<option "; if($DATA->priorite=='3') echo ' selected '; echo "value='3'>Faible</option>";
                                echo "</select>";
                            echo " Etat : ";
                                echo "<select name='etat'>";
                                    echo "<option "; if($DATA->etat=='A faire') echo ' selected '; echo "value='A faire'>A faire</option>";
                                    echo "<option "; if($DATA->etat=='Fait') echo ' selected '; echo "value='Fait'>Fait</option>";
                                echo "</select>";
                            echo " Date : ";
                                echo "<select name='jour'>";
                                    for($x=1;$x<32;$x++){
                                        if(strlen($x)==1){
                                            echo "<option "; if(substr($date=$DATA->date,8,2)=='0'.$x) echo ' selected '; echo "value='0$x'>0$x</option>";
                                        }
                                        if(strlen($x)==2){
                                            echo "<option "; if(substr($date=$DATA->date,8,2)==$x) echo ' selected '; echo "value='$x'>$x</option>";
                                        }
                                    }
                                echo "</select>";
                                echo " ";

                                echo "<select name='mois'>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='01') echo ' selected '; echo "value='01'>janvier</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='02') echo ' selected '; echo "value='02'>f&eacute;vrier</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='03') echo ' selected '; echo "value='03'>mars</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='04') echo ' selected '; echo "value='04'>avril</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='05') echo ' selected '; echo "value='05'>mai</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='06') echo ' selected '; echo "value='06'>juin</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='07') echo ' selected '; echo "value='07'>juiller</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='08') echo ' selected '; echo "value='08'>aout</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='09') echo ' selected '; echo "value='09'>septembre</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='10') echo ' selected '; echo "value='10'>octobre</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='11') echo ' selected '; echo "value='11'>novembre</option>";
                                    echo "<option "; if(substr($date=$DATA->date,5,2)=='12') echo ' selected '; echo "value='12'>d&eacute;cembre</option>";
                                echo "</select>";
                                echo " ";
                                echo "<select name='annee'>";
                                $date=$DATA->date;
                                    for($y=2010;$y<2021;$y++){
                                        if($y==substr($date, 0, 4)) echo "<option selected value='$y'>$y</option>";
                                        else echo "<option value='$y'>$y</option>";
                                    }

                                echo "</select><br>";
                                echo "<input type='submit' value='Valider les changements'>";
                            echo "</form>";
                    echo "</div>";

        }
    }

function no_projet_defaut(){
        $request1="SELECT no_projet FROM projet WHERE login='".$_SESSION['login']."' AND titre_proj='defaut'";
        $connexion1=mysql_query($request1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $DATA1=mysql_fetch_object($connexion1);
        echo $DATA1->no_projet;
}

function menu_tache(){
        echo "<ul><li class='centrale_menu_ajout'><img src='vue/images/ajout_activite.png' alt='act'>  <a href=\"#\" onclick=\"Effect.toggle('toggle_new', 'appear'); return false;\">Ajouter une tache</a></li>  <li><img src='vue/images/supprimer.png' alt='supp'>  <a id='supprimer_tache' href='action.php?source=tache&operation=supprimer'>Supprimer la/les t&acirc;che(s) s&eacute;lectionn&eacute;es</a></li></ul>";
}



$_SESSION['affichage']="tache";

/* DEFINITION DU FICHIER "VUE" ASSOCIE A CE FICHIER */
include_once 'vue/activite.php';

?>
