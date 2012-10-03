<?php

session_start();
require_once 'auth_securite.php';


$db=mysql_connect("localhost", "root", "root");
mysql_select_db("projet",$db);

$login = $_SESSION['login'];


function formulaire_cache_ajout_projet() {
    echo "<div id='toggle_new' style=\"display:none;\" class='maj_tache' >";
    echo "<form action='action.php?source=projet&operation=creer' method='post'>";

    echo "Projet : <input type='text' name='titre_proj'>";
    echo "<hr>";

    echo "<textarea name='note' rows='2' cols='63'></textarea><br>";

    echo "Couleur : ";
    echo "<select name='couleur'>";
    echo "<option selected value='#FFFFFF'>Blanc</option>";
    echo "<option value='#F6E8B1'>Beige</option>";
    echo "<option value='#B0CC99'>Vert 1</option>";
    echo "<option value='#B7CA79'>Vert 2</option>";
    echo "<option value='#5EB6DD'>Bleu 1</option>";
    echo "<option value='#C4D7ED'>Bleu 2</option>";
    echo "<option value='#ABC8E2'>Bleu 3</option>";
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
    echo "<input type='submit' value='Cr&eacute;er ce projet'>";
    echo "</form>";
    echo "</div>";
}


function afficher_projet(){

        formulaire_cache_ajout_projet();

        $request="SELECT * FROM projet WHERE login='".$_SESSION['login']."'";
        $connexion = mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat = mysql_num_rows($connexion);
        for($compteur=0;$compteur<$resultat;$compteur++){
            $DATA=mysql_fetch_object($connexion);
            echo "<div class='projet' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                    <div class='projet_un'>
                        <div class='centrer_contenu'>
                            <table>
                                <tr>
                                    <td><input id='$DATA->no_projet' type='checkbox' value='$DATA->no_projet' name='projet' onclick='test(this.value)'></td>
                                    <td width='300px'><a href='activite.php?projet=$DATA->no_projet'>Projet : ".$DATA->titre_proj."</a></td>
                                    <td width='170px'>  <a href=\"#\" onclick=\"Effect.toggle('toggle_i_$DATA->no_projet', 'slide'); Effect.toggle('toggle_d_$DATA->no_projet', 'appear');return false;\"><i>Informations</i></a></td>
                                    <td>                <a href=\"#\" onclick=\"Effect.toggle('toggle_$DATA->no_projet', 'appear'); return false;\"><i>Update</i></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class='projet_deux' style='background-color:$DATA->couleur;'>
                        <div class='centrer_contenu'>
                            <div id='toggle_d_$DATA->no_projet' style=\"display:none;text-align:center;\"><u>";
                            echo substr($DATA->date,8,2)."/";
                            echo substr($DATA->date,5,2)."/";
                            echo substr($DATA->date,0,4);
                            echo "</u></div>
                        </div>
                    </div>
                </div>";
                echo "<div id='toggle_i_$DATA->no_projet' style=\"display:none;\" class='info_projet' >";
                echo "<fieldset><legend>Commentaires</legend>";
                echo "$DATA->note<br>";
                echo "</fieldset>";
                echo "</div>";
                echo "<div id='toggle_$DATA->no_projet' style=\"display:none;\" class='maj_projet' >";
                    echo "<form action='action.php?source=projet&operation=modification' method='post'>";
                    echo "<input type='hidden' name='no_projet' value='$DATA->no_projet'>";
                        echo "Projet : <input type='text' name='titre_proj' value='".str_replace("'", "&#039;", $DATA->titre_proj)."'>";
                            echo "<hr>";
                            echo "<textarea name='note' rows='2' cols='63'>$DATA->note</textarea><br>";
                            echo "Couleur : ";
                                echo "<select name='couleur'>";
                                    echo "<option value='$DATA->couleur' SELECTED>Actuelle</option>";
                                    echo "<option value='#F6E8B1'>Beige</option>";
                                    echo "<option value='#B0CC99'>Vert 1</option>";
                                    echo "<option value='#B7CA79'>Vert 2</option>";
                                    echo "<option value='#5EB6DD'>Bleu 1</option>";
                                    echo "<option value='#C4D7ED'>Bleu 2</option>";
                                    echo "<option value='#ABC8E2'>Bleu 3</option>";
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
        $request="SELECT no_projet FROM projet WHERE login='".$_SESSION['login']."' AND titre_proj='defaut'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $DATA=mysql_fetch_object($connexion);
        echo $DATA->no_projet;
}

function menu_projet(){
        echo "<ul><li class='centrale_menu_ajout'><img src='vue/images/ajout_projet.png' alt='proj'>  <a href=\"#\" onclick=\"Effect.toggle('toggle_new', 'appear'); return false;\">Ajouter un projet</a></li>  <li><img src='vue/images/supprimer.png' alt='supp'>  <a id='supprimer_projet' href='action.php?source=projet&operation=supprimer'>Supprimer le(s) projet(s) s&eacute;lectionn&eacute;s</a></li></ul>";
}

$_SESSION['affichage']="projet";

/* DEFINITION DU FICHIER "VUE" ASSOCIE A CE FICHIER */
include_once 'vue/activite.php';

?>
