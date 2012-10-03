<?php

/* ========================================
    FICHIER CONTROLEUR DE LA PAGE ACTIVITE
   ======================================== */

/* APPEL DE LA CLASSE ACTIVITE */
require_once 'modele/Cactivite.php';

/* DEMARRER LA SESSION ET ... */
session_start();
require_once 'auth_securite.php';


$db=mysql_connect("localhost", "root", "root");
mysql_select_db("projet",$db);

/* ... RECUPERER LE LOGIN DE L'UTILISATEUR COURANT */
$login = $_SESSION['login'];


function formulaire_cache_ajout_activite() {
    echo "<div id='toggle_new' style=\"display:none;\" class='maj_tache' >";
    echo "<form action='action.php?source=activite&operation=creer' method='post'>";
    echo "<input type='hidden' name='no_projet_courant' value='" . $_SESSION['projet'] . "'>";
    echo "Activit&eacute; : <input type='text' name='activite'>";
    
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
    echo "<input type='submit' value='Cr&eacute;er cette activit&eacute;'>";
    echo "</form>";
    echo "</div>";
}


if(isset($_GET['projet']) && !isset($_GET['date']) && !isset($_GET['etat'])) {

    $_SESSION['projet'] = $_GET['projet'];
    unset($_SESSION['date']);
    unset($_SESSION['etat']);
    $_SESSION['menu']="oui";
    function afficher_activite(){

        formulaire_cache_ajout_activite();

        $projet=$_SESSION['projet'];

        /*Récupération des activités de ce projet*/
        $request1="SELECT * FROM activite AS a, projet AS p WHERE a.no_projet=p.no_projet AND a.login='".$_SESSION['login']."' AND p.no_projet='$projet'";
        $connexion1=mysql_query($request1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat1=mysql_num_rows($connexion1);

        /*Récupération du nom du projet */
        $request3="SELECT titre_proj FROM projet WHERE login='".$_SESSION['login']."' AND no_projet='$projet'";
        $connexion3=mysql_query($request3);
        $DATA3=mysql_fetch_object($connexion3);

        /*Affichage du projet sélectionné*/
        $request2="SELECT * FROM projet WHERE login='".$_SESSION['login']."' AND no_projet='$projet'";
        $connexion2=mysql_query($request2) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $DATA2=mysql_fetch_object($connexion2);
        echo "  <div class='projet' style='background-color:$DATA2->couleur;'>
                    <div class='projet_un'>
                        <div class='centrer_contenu'>
                            <table>
                                <tr>
                                    <td>Projet : ".$DATA2->titre_proj."</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class='projet_deux' style='background-color:$DATA2->couleur;'>
                        <div class='centrer_contenu'>

                        </div>
                    </div>
                </div>";

        /*Affichage des activités du projet*/  
        for($compteur=0;$compteur<$resultat1;$compteur++){
            $DATA=mysql_fetch_object($connexion1);
            echo "  <div class='activite' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                        <div class='activite_un'>
                            <div class='centrer_contenu'>
                                <table>
                                    <tr>
                                        <td><input id='$DATA->no_activite' type='checkbox' name='activite' value='$DATA->no_activite' onclick='test(this.value)'></td>
                                        <td width='300px'><b><a href='tache.php?activite=$DATA->no_activite'> $DATA->titre_act</a></b></td>
                                        <td width='95px'><a href=\"#\" onclick=\"Effect.toggle('toggle_i_$DATA->no_activite', 'slide'); Effect.toggle('toggle_d_$DATA->no_activite', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td><i><a href=\"#\" onclick=\"Effect.toggle('toggle_$DATA->no_activite', 'appear'); return false;\">Update</a></i></td>
                                    </tr>
                                </table>
                                    
                            </div>
                            
                        </div>
                        <div class='activite_deux' style='background-color:$DATA2->couleur;'>
                            <div class='centrer_contenu'>";


                    /*Récupération des informations sur l'activité*/
                    $request5="SELECT * FROM activite WHERE login='".$_SESSION['login']."' AND no_activite='$DATA->no_activite'";
                    $connexion5=mysql_query($request5) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                    $DATA5=mysql_fetch_object($connexion5);


                            echo "<div id='toggle_d_$DATA5->no_activite' style=\"display:none;text-align:center;\"><u>";
                            echo substr($DATA5->date,8,2)."/";
                            echo substr($DATA5->date,5,2)."/";
                            echo substr($DATA5->date,0,4);
                            echo "</u></div>
                            </div>
                        </div>
                    </div>";

                    echo "<div id='toggle_i_$DATA->no_activite' style=\"display:none;\" class='info_activite' >";
                    echo "<fieldset><legend>Commentaires</legend>";
                    echo "$DATA5->note<br>";
                    echo "</fieldset>";
                    echo "</div>"; 

                    
                    
                    /*Affichage du formulaire de mise à jour d'une activité*/
                    echo "<div id='toggle_$DATA->no_activite' style=\"display:none;\" class='maj_activite' >";
                    echo "<form action='action.php?source=activite&operation=modification' method='post'>";
                    echo "<input type='hidden' name='no_activite' value='$DATA->no_activite'>";
                    echo "<input type='hidden' name='no_projet_courant' value='$DATA2->no_projet'>";
                        echo "Activite : <input type='text' name='activite' value='".str_replace("'", "&#039;", $DATA->titre_act)."'>";
                        echo " dans le Projet ";
                            echo "<select name='projet'>";
                                $request4="SELECT * FROM projet";
                                $connexion4=mysql_query($request4) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                                $resultat4=mysql_num_rows($connexion4);
                                for($j=1;$j<$resultat4;$j++){
                                    $DATA4=mysql_fetch_object($connexion4);
                                    if($DATA4->no_projet==$DATA2->no_projet) echo "<option value='$DATA4->no_projet' SELECTED>$DATA4->titre_proj</option>";
                                    else echo "<option value='$DATA4->no_projet'>$DATA4->titre_proj</option>";
                                }
                            echo "</select>";
                            echo "<hr>";
                            echo "<textarea rows='2' cols='63' name='note'>$DATA5->note</textarea><br>";
                            echo "Priorit&eacute; : ";
                                echo "<select name='priorite'>";
                                    echo "<option "; if($DATA5->priorite=='1') echo ' selected '; echo "value='1'>Forte</option>";
                                    echo "<option "; if($DATA5->priorite=='2') echo ' selected '; echo "value='2'>Moyenne</option>";
                                    echo "<option "; if($DATA5->priorite=='3') echo ' selected '; echo "value='3'>Faible</option>";
                                echo "</select>";
                            echo " Etat : ";
                                echo "<select name='etat'>";
                                    echo "<option "; if($DATA5->etat=='A faire') echo ' selected '; echo "value='A faire'>A faire</option>";
                                    echo "<option "; if($DATA5->etat=='Fait'   ) echo ' selected '; echo "value='Fait'>Fait</option>";
                                echo "</select>";
                            echo " Date : ";
                                echo "<select name='jour'>";
                                    for($x=1;$x<32;$x++){
                                        if(strlen($x)==1){
                                            echo "<option "; if(substr($date=$DATA5->date,8,2)=='0'.$x) echo ' selected '; echo "value='0$x'>0$x</option>";
                                        }
                                        if(strlen($x)==2){
                                            echo "<option "; if(substr($date=$DATA5->date,8,2)==$x) echo ' selected '; echo "value='$x'>$x</option>";
                                        }
                                    }
                                echo "</select>";
                                echo " ";
                                echo "<select name='mois'>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='01') echo ' selected '; echo "value='01'>janvier</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='02') echo ' selected '; echo "value='02'>f&eacute;vrier</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='03') echo ' selected '; echo "value='03'>mars</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='04') echo ' selected '; echo "value='04'>avril</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='05') echo ' selected '; echo "value='05'>mai</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='06') echo ' selected '; echo "value='06'>juin</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='07') echo ' selected '; echo "value='07'>juiller</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='08') echo ' selected '; echo "value='08'>aout</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='09') echo ' selected '; echo "value='09'>septembre</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='10') echo ' selected '; echo "value='10'>octobre</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='11') echo ' selected '; echo "value='11'>novembre</option>";
                                    echo "<option "; if(substr($date=$DATA5->date,5,2)=='12') echo ' selected '; echo "value='12'>d&eacute;cembre</option>";
                                echo "</select>";
                                echo " ";
                                echo "<select name='annee'>";
                                $date=$DATA5->date;
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
}

if(!isset($_GET['projet']) && isset($_GET['date']) && !isset($_GET['etat']) && !isset($_GET['tard']) && !isset($_GET['retard'])) {

    unset($_SESSION['projet']);
    unset($_SESSION['etat']);
    $_SESSION['date'] = $_GET['date'];
    $_SESSION['menu']="non";
    function afficher_activite(){
        
        $date=$_SESSION['date'];

        /* AFFICHAGE DES PROJETS ARRIVANT A ECHEANCE AUJOURD'HUI*/
        $request="SELECT * FROM projet WHERE login='".$_SESSION['login']."' AND date='$date'";
        
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat=mysql_num_rows($connexion);
        for($compteur=0;$compteur<$resultat;$compteur++){
            
            $DATA2=mysql_fetch_object($connexion);
            echo "  <div class='projet' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                        <div class='projet_un'>
                            <div class='centrer_contenu'>
                                <table>
                                    <tr>
                                        <td><input type='checkbox' name='' value='$DATA2->no_projet'></td>
                                        <td width='300px'><a href='projet.php'> $DATA2->titre_proj</a></td>
                                        <td width='170px'><a href=\"#\" onclick=\"Effect.toggle('toggle_ip_$DATA2->no_projet', 'slide'); Effect.toggle('toggle_d_$DATA->no_projet', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td ";  if($DATA2->etat=='A faire') echo "style='color:red;'><i><b>Aujourd'hui<b></i></td>";
                                                if($DATA2->etat=='Fait') echo "style='color:green'><i><b>Aujourd'hui<b></i></td>";
                                    echo "</tr>
                                </table>

                            </div>

                        </div>
                        <div class='projet_deux' style='background-color:$DATA2->couleur;'>
                            <div class='centrer_contenu'>
                                <b>$DATA2->etat</b>
                            </div>
                        </div>
                    </div>";
                echo "<div id='toggle_ip_$DATA2->no_projet' style=\"display:none;\" class='info_projet' >";
                echo "<fieldset><legend>Commentaires</legend>";
                echo "$DATA2->note<br>";
                echo "</fieldset>";
                echo "</div>";
        }

        /* AFFICHAGE DES ACTIVITES ARRIVANT A ECHEANCE AUJOURD'HUI*/
        $request="SELECT * FROM activite WHERE login='".$_SESSION['login']."' AND date='$date'";
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
                                        <td><input type='checkbox' name='' value='$DATA->no_activite'></td>
                                        <td width='300px'><a href='activite.php?projet=$DATA->no_projet'> $DATA->titre_act</a></td>
                                        <td width='95px' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ia_$DATA->no_activite', 'slide'); Effect.toggle('toggle_d_$DATA->no_activite', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td ";  if($DATA->etat=='A faire') echo "style='color:red;'";
                                                if($DATA->etat=='Fait') echo "style='color:green'";
                                        echo "><i><b>Aujourd'hui<b></i></td>
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

        /* AFFICHAGE DES TACHES ARRIVANT A ECHEANCE AUJOURD'HUI*/
        $request="SELECT * FROM tache WHERE login='".$_SESSION['login']."' AND date='$date'";
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
                                        <td><input type='checkbox' name='' value='$DATA->no_tache'></td>
                                        <td width='300px'><a href='tache.php?activite=$DATA->no_activite'> $DATA->titre_tache</a></td>
                                        <td width='20px' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_it_$DATA->no_tache', 'slide'); Effect.toggle('toggle_d_$DATA->no_tache', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td ";  if($DATA->etat=='A faire') echo "style='color:red;'";
                                                if($DATA->etat=='Fait') echo "style='color:green'";
                                        echo "><i><b>Aujourd'hui<b></i></td>
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
}

if(!isset($_GET['projet']) && isset($_GET['date']) && !isset($_GET['etat']) && isset($_GET['tard'])) {

    unset($_SESSION['projet']);
    unset($_SESSION['etat']);
    $_SESSION['date'] = $_GET['date'];
    $_SESSION['menu']="non";
    function afficher_activite(){
        $date=$_SESSION['date'];

        $annee=substr($date, 0, 4);
        $mois=substr($date, 5, 2);
        $jour=substr($date, 8, 2);

/*CALCUL DE LA DATE DANS UNE SEMAINE*/
    /*GESTION DES MOIS DE 31 JOURS*/
        if($mois=='01' || $mois=='03' || $mois=='05' || $mois=='07' || $mois=='08' || $mois=='10' || $mois=='12'){
            if($jour<=24){
                $nouveau_jour=$jour+7;
                $nouveau_mois=$mois;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>24 && $mois<=11){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois=$mois+1;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>24 && $mois==12){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois='01';
                $nouvelle_annee=$annee+1;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
        }
        
    /*GESTION DES MOIS DE 30 JOURS*/
        if($mois=='04' || $mois=='06' || $mois=='09' || $mois=='11'){
            if($jour<=23){
                $nouveau_jour=$jour+7;
                $nouveau_mois=$mois;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>23 && $mois<=11){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois=$mois+1;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>23 && $mois==12){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois='01';
                $nouvelle_annee=$annee+1;
                if(strlen($nouveau_jour)==1) $nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1) $nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            
        }
        
    /*GESTION DU MOIS DE FEVRIER DANS UNE ANNEE BISSEXTILE*/
        if($mois=='02' && $annee%4==0 && $annee%100!=0){
            $annee_bissextile='oui';
            if($jour<=22){
                $nouveau_jour=$jour+7;
                $nouveau_mois=$mois;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>22 && $mois<=11){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois=$mois+1;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>22 && $mois==12){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois='01';
                $nouvelle_annee=$annee+1;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
        }
        
    /*GESTION DU MOIS DE FEVRIER DANS UNE ANNEE BISSEXTILE*/
        if($mois=='02' && $annee%400==0){
            $annee_bissextile='oui';
            if($jour<=22){
                $nouveau_jour=$jour+7;
                $nouveau_mois=$mois;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>22 && $mois<=11){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois=$mois+1;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>22 && $mois==12){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois='01';
                $nouvelle_annee=$annee+1;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
        }

    /*GESTION DU MOIS DE FEVRIER DANS UNE ANNEE NON BISSEXTILE*/
        if($mois=='02' && !isset($annee_bissextile)){
            if($jour<=21){
                $nouveau_jour=$jour+7;
                $nouveau_mois=$mois;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>21 && $mois<=11){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois=$mois+1;
                $nouvelle_annee=$annee;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
            if($jour>21 && $mois==12){
                $ecart=$jour-31;
                $nouveau_jour=$ecart+7;
                $nouveau_mois='01';
                $nouvelle_annee=$annee+1;
                if(strlen($nouveau_jour)==1)$nouveau_jour='0'.$nouveau_jour;
                if(strlen($nouveau_mois)==1)$nouveau_mois='0'.$nouveau_mois;
                $nouvelle_date=$nouvelle_annee."-".$nouveau_mois."-".$nouveau_jour;
            }
        }
        
    /* AFFICHAGE DES PROJETS ARRIVANT BIENTOT A ECHEANCE */
        $request="SELECT * FROM projet WHERE login='".$_SESSION['login']."' AND date<='$nouvelle_date' AND date>='$date' ORDER BY date ASC";
        
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat=mysql_num_rows($connexion);
        for($compteur=0;$compteur<$resultat;$compteur++){
            $DATA2=mysql_fetch_object($connexion);
            echo "  <div class='projet' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                        <div class='projet_un'>
                            <div class='centrer_contenu'>
                                <table>
                                    <tr>
                                        <td><input type='checkbox' name='' value='$DATA2->no_projet'></td>
                                        <td width='300px'><a href='projet.php'> $DATA2->titre_proj</a></td>
                                        <td width='170px' align='right' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ip_$DATA2->no_projet', 'slide'); Effect.toggle('toggle_d_$DATA->no_projet', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td >"; echo substr($DATA2->date,8,2)."/".substr($DATA2->date,5,2)."/".substr($DATA2->date,0,4); echo "</td>";
                                    echo "</tr>
                                </table>

                            </div>

                        </div>
                        <div class='projet_deux' style='background-color:$DATA2->couleur;'>
                            <div class='centrer_contenu'>
                                <b>$DATA2->etat</b>
                            </div>
                        </div>
                    </div>";
                    echo "<div id='toggle_ip_$DATA2->no_projet' style=\"display:none;\" class='info_projet' >";
                echo "<fieldset><legend>Commentaires</legend>";
                echo "$DATA2->note<br>";
                echo "</fieldset>";
                echo "</div>";
        }

        /* AFFICHAGE DES ACTIVITES ARRIVANT BIENTOT A ECHEANCE*/
        $request="SELECT * FROM activite WHERE login='".$_SESSION['login']."' AND date<='$nouvelle_date' AND date>='$date' ORDER BY date ASC";
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
                                        <td><input type='checkbox' name='' value='$DATA->no_activite'></td>
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
        $request="SELECT * FROM tache WHERE login='".$_SESSION['login']."' AND date<='$nouvelle_date' AND date>='$date' ORDER BY date ASC";
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
                                        <td><input type='checkbox' name='' value='$DATA->no_tache'></td>
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
}

if(!isset($_GET['projet']) && isset($_GET['date']) && !isset($_GET['etat']) && isset($_GET['retard'])) {

    unset($_SESSION['projet']);
    unset($_SESSION['etat']);
    $_SESSION['date'] = $_GET['date'];
    $_SESSION['menu']="non";
    function afficher_activite(){
        $date=$_SESSION['date'];
        $date= substr($date, 0, 10);
        
        /* AFFICHAGE DES PROJETS EN RETARD */
        $request="SELECT * FROM projet WHERE login='".$_SESSION['login']."' AND date<'$date' AND etat='A faire'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat=mysql_num_rows($connexion);
        for($compteur=0;$compteur<$resultat;$compteur++){
            $DATA2=mysql_fetch_object($connexion);
            echo "  <div class='projet' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                        <div class='projet_un'>
                            <div class='centrer_contenu'>
                                <table>
                                    <tr>
                                        <td><input type='checkbox' name='' value='$DATA2->no_projet'></td>
                                        <td width='300px'><a href='projet.php'> $DATA2->titre_proj</a></td>
                                        <td width='170px' style='color:red;'><td width='170px' align='right' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ip_$DATA2->no_projet', 'slide'); Effect.toggle('toggle_d_$DATA->no_projet', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td style='color:red;'><i><b>Retard<b></i></td>
                                    </tr>
                                </table>

                            </div>

                        </div>
                        <div class='projet_deux' style='background-color:$DATA2->couleur;'>
                            <div class='centrer_contenu'>
                                <b>$DATA2->etat</b>
                            </div>
                        </div>
                    </div>";
                    echo "<div id='toggle_ip_$DATA2->no_projet' style=\"display:none;\" class='info_projet' >";
                echo "<fieldset><legend>Commentaires</legend>";
                echo "$DATA2->note<br>";
                echo "</fieldset>";
                echo "</div>";
        }

        /* AFFICHAGE DES ACTIVITES EN RETARD*/
        $request="SELECT * FROM activite WHERE login='".$_SESSION['login']."' AND date<'$date' AND etat='A faire'";
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
                                        <td><input type='checkbox' name='' value='$DATA->no_activite'></td>
                                        <td width='300px'><a href='activite.php?projet=$DATA->no_projet'> $DATA->titre_act</a></td>
                                        <td width='107px' align='right' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ia_$DATA->no_activite', 'slide'); Effect.toggle('toggle_d_$DATA->no_activite', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td style='color:red;'><i><b>Retard<b></i></td>
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

        /* AFFICHAGE DES TACHES ARRIVANT EN RETARDI*/
        $request="SELECT * FROM tache WHERE login='".$_SESSION['login']."' AND date<'$date' AND etat='A faire'";
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
                                        <td><input type='checkbox' name='' value='$DATA->no_tache'></td>
                                        <td width='300px'><a href='tache.php?activite=$DATA->no_activite'> $DATA->titre_tache</a></td>
                                        <td width='20px' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_it_$DATA->no_tache', 'slide'); Effect.toggle('toggle_d_$DATA->no_tache', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td style='color:red;'><i><b>Retard<b></i></td>
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
}

if(isset($_GET['etat'])) {

    unset($_SESSION['projet']);
    unset($_SESSION['date']);
    $_SESSION['etat'] = $_GET['etat'];
    $_SESSION['menu']="non";
    function afficher_activite(){
        $etat=$_SESSION['etat'];
        
        /* AFFICHAGE DES PROJETS FAITS */
        $request="SELECT * FROM projet WHERE login='".$_SESSION['login']."' AND etat='$etat'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $resultat=mysql_num_rows($connexion);
        for($compteur=0;$compteur<$resultat;$compteur++){
            $DATA2=mysql_fetch_object($connexion);
            echo "  <div class='projet' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                        <div class='projet_un'>
                            <div class='centrer_contenu'>
                                <table>
                                    <tr>
                                        <td><input type='checkbox' name='' value='$DATA2->no_projet'></td>
                                        <td width='300px'><a href='projet.php'> $DATA2->titre_proj</a></td>
                                        <td width='170px' style='color:red;'><td width='170px' align='right' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ip_$DATA2->no_projet', 'slide'); Effect.toggle('toggle_d_$DATA->no_projet', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td style='color:green;' width='20px'><i></i></td>
                                    </tr>
                                </table>

                            </div>

                        </div>
                        <div class='projet_deux' style='background-color:$DATA2->couleur;'>
                            <div class='centrer_contenu'>
                                <b>$DATA2->etat</b>
                            </div>
                        </div>
                    </div>";
                    echo "<div id='toggle_ip_$DATA2->no_projet' style=\"display:none;\" class='info_projet' >";
                echo "<fieldset><legend>Commentaires</legend>";
                echo "$DATA2->note<br>";
                echo "</fieldset>";
                echo "</div>";
        }

        /* AFFICHAGE DES ACTIVITES FAITES*/
        $request="SELECT * FROM activite WHERE login='".$_SESSION['login']."' AND etat='$etat'";
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
                                        <td><input type='checkbox' name='' value='$DATA->no_activite'></td>
                                        <td width='300px'><a href='activite.php?projet=$DATA->no_projet'> $DATA->titre_act</a></td>
                                        <td width='145px' align='right' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ia_$DATA->no_activite', 'slide'); Effect.toggle('toggle_d_$DATA->no_activite', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td style='color:green;' width='20px'><i></i></td>
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

        /* AFFICHAGE DES TACHES FAITES*/
        $request="SELECT * FROM tache WHERE login='".$_SESSION['login']."' AND etat='$etat'";
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
                                        <td><input type='checkbox' name='' value='$DATA->no_tache'></td>
                                        <td width='300px'><a href='tache.php?activite=$DATA->no_activite'> $DATA->titre_tache</a></td>
                                        <td width='20px' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_it_$DATA->no_tache', 'slide'); Effect.toggle('toggle_d_$DATA->no_tache', 'appear');return false;\"><i>Informations</i></a></td>
                                        <td style='color:green;' width='20px'><i></i></td>
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
}

 if(isset($_GET['interval'])) {

    unset($_SESSION['projet']);
    unset($_SESSION['etat']);
    unset($_SESSION['date']);
    $_SESSION['date'] = $_GET['date'];
    $_SESSION['menu']="non";
    
    function afficher_activite() {
        function afficher_menu(){

                $jour1=$_POST['jour1'];
                $mois1=$_POST['mois1'];
                $annee1=$_POST['annee1'];

                $jour2=$_POST['jour2'];
                $mois2=$_POST['mois2'];
                $annee2=$_POST['annee2'];

                echo "<div>";
                echo "<form action='activite.php?interval=oui&pret=oui' method='POST'>";
                echo " De : ";
                echo "<select name='jour1' >";
                for ($x = 1; $x < 32; $x++) {
                    if (strlen($x) == 1) {
                        echo "<option "; if($jour1=='0'.$x) echo "selected"; echo " value='0$x'>0$x</option>";
                    }
                    if (strlen($x) == 2) {
                        echo "<option "; if($jour1==$x) echo "selected"; echo " value='$x'>$x</option>";
                    }
                }
                echo "</select>";
                echo " ";

                echo "<select name='mois1'>";
                echo "<option "; if(isset ($mois1) && $mois1=='01') echo 'selected'; echo " value='01'>janvier</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='02') echo 'selected'; echo " value='02'>f&eacute;vrier</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='03') echo 'selected'; echo " value='03'>mars</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='04') echo 'selected'; echo " value='04'>avril</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='05') echo 'selected'; echo " value='05'>mai</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='06') echo 'selected'; echo " value='06'>juin</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='07') echo 'selected'; echo " value='07'>juiller</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='08') echo 'selected'; echo " value='08'>aout</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='09') echo 'selected'; echo " value='09'>septembre</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='10') echo 'selected'; echo " value='10'>octobre</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='11') echo 'selected'; echo " value='11'>novembre</option>";
                echo "<option "; if(isset ($mois1) && $mois1=='12') echo 'selected'; echo " value='12'>d&eacute;cembre</option>";
                echo "</select>";
                echo " ";
                echo "<select name='annee1'>";
                for ($y = 2010; $y < 2021; $y++) {
                    echo "<option "; if(isset($annee1) && $annee1==$y) echo "selected"; echo " value='$y'>$y</option>";
                }

                echo "</select>";

                echo "  A : ";
                echo "<select name='jour2' >";
                for ($x = 1; $x < 32; $x++) {
                    if (strlen($x) == 1) {
                        echo "<option "; if(isset($jour2) && $jour2=='0'.$x) echo "selected"; echo " value='0$x'>0$x</option>";
                    }
                    if (strlen($x) == 2) {
                        echo "<option "; if(isset($jour2) && $jour2==$x) echo "selected"; echo " value='$x'>$x</option>";
                    }
                }
                echo "</select>";
                echo " ";

                echo "<select name='mois2'>";
                echo "<option "; if(isset ($mois2) && $mois2=='01') echo 'selected'; echo " value='01'>janvier</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='02') echo 'selected'; echo " value='02'>f&eacute;vrier</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='03') echo 'selected'; echo " value='03'>mars</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='04') echo 'selected'; echo " value='04'>avril</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='05') echo 'selected'; echo " value='05'>mai</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='06') echo 'selected'; echo " value='06'>juin</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='07') echo 'selected'; echo " value='07'>juiller</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='08') echo 'selected'; echo " value='08'>aout</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='09') echo 'selected'; echo " value='09'>septembre</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='10') echo 'selected'; echo " value='10'>octobre</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='11') echo 'selected'; echo " value='11'>novembre</option>";
                echo "<option "; if(isset ($mois2) && $mois2=='12') echo 'selected'; echo " value='12'>d&eacute;cembre</option>";
                echo "</select>";
                echo " ";
                echo "<select name='annee2'>";
                for ($y = 2010; $y < 2021; $y++) {
                    echo "<option "; if(isset($annee2) && $annee2==$y) echo "selected"; echo " value='$y'>$y</option>";
                }

                echo "</select>";
                echo "<input type='submit' value='Rechercher'>";
                echo "</form>";
                echo "</div>
                ";
        }
        afficher_menu();
        if(isset($_GET['pret'])) {
            $date1=$_POST['annee1']."-".$_POST['mois1']."-".$_POST['jour1'];
            $date2=$_POST['annee2']."-".$_POST['mois2']."-".$_POST['jour2'];
            afficher_les_resultats($date1,$date2);
        }
    }
    function afficher_les_resultats($date_debut,$date_fin) {

          function afficher_projets($date_debut,$date_fin){
              $request="SELECT * FROM projet WHERE login='".$_SESSION['login']."' AND date<='$date_fin' AND date>='$date_debut' ORDER BY date ASC";
              $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
              $resultat=mysql_num_rows($connexion);

              for($compteur=0;$compteur<$resultat;$compteur++){
                  $DATA=mysql_fetch_object($connexion);
                  echo "  <div class='projet' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                  <div class='projet_un'>
                  <div class='centrer_contenu'>
                  <table>
                  <tr>
                  <td><input type='checkbox' name='' value='$DATA->no_projet'></td>
                  <td width='300px'><a href='projet.php'> $DATA->titre_proj</a></td>
                  <td width='170px' align='right' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ip_$DATA->no_projet', 'slide'); Effect.toggle('toggle_d_$DATA->no_projet', 'appear');return false;\"><i>Informations</i></a></td>
                  <td >"; echo substr($DATA->date,8,2)."/".substr($DATA->date,5,2)."/".substr($DATA->date,0,4); echo "</td>";
                  echo "</tr>
                  </table>

                  </div>

                  </div>
                  <div class='projet_deux' style='background-color:$DATA->couleur;'>
                  <div class='centrer_contenu'>
                  <b>$DATA->etat</b>
                  </div>
                  </div>
                  </div>";
                  echo "<div id='toggle_ip_$DATA->no_projet' style=\"display:none;\" class='info_projet' >";
                  echo "<fieldset><legend>Commentaires</legend>";
                  echo "$DATA->note<br>";
                  echo "</fieldset>";
                  echo "</div>";
              }
          }
          function afficher_activites($date_debut,$date_fin){
                    $request = "SELECT * FROM activite WHERE login='".$_SESSION['login']."' AND date<='$date_fin' AND date>='$date_debut' ORDER BY date ASC";
                    $connexion = mysql_query($request) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
                    $resultat = mysql_num_rows($connexion);
                    
                for ($compteur = 0; $compteur < $resultat; $compteur++) {
                    $DATA1 = mysql_fetch_object($connexion);
                    $request1 = "SELECT couleur FROM projet WHERE no_projet='$DATA1->no_projet'";
                    $connexion1 = mysql_query($request1) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
                    $DATA2 = mysql_fetch_object($connexion1);
                    echo "  <div class='activite' onmouseover=\"this.style.borderWidth='2px';\" onmouseout=\"this.style.borderWidth='1px';\">
                    <div class='activite_un'>
                    <div class='centrer_contenu'>
                    <table>
                    <tr>
                    <td><input type='checkbox' name='' value='$DATA1->no_activite'></td>
                    <td width='300px'><a href='activite.php?projet=$DATA1->no_projet'> $DATA1->titre_act</a></td>
                    <td width='95px' align='right' style='color:red;'><a href=\"#\" onclick=\"Effect.toggle('toggle_ia_$DATA1->no_activite', 'slide'); Effect.toggle('toggle_d_$DATA1->no_activite', 'appear');return false;\"><i>Informations</i></a></td>
                    <td >";
                    echo substr($DATA1->date, 8, 2) . "/" . substr($DATA1->date, 5, 2) . "/" . substr($DATA1->date, 0, 4);
                    echo "</td>
                    </tr>
                    </table>

                    </div>

                    </div>
                    <div class='activite_deux' style='background-color:$DATA2->couleur;'>
                    <div class='centrer_contenu'>
                    <b>$DATA1->etat</b>
                    </div>
                    </div>
                    </div>";
                    echo "<div id='toggle_ia_$DATA1->no_activite' style=\"display:none;\" class='info_activite' >";
                    echo "<fieldset><legend>Commentaires</legend>";
                    echo "$DATA1->note<br>";
                    echo "</fieldset>";
                    echo "</div>";
                }
          }
          function afficher_taches($date_debut,$date_fin){
                  $request="SELECT * FROM tache WHERE login='".$_SESSION['login']."' AND date<='$date_fin' AND date>='$date_debut' ORDER BY date ASC";
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
                  <td><input type='checkbox' name='' value='$DATA->no_tache'></td>
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
            
          
          afficher_projets($date_debut,$date_fin);
          afficher_activites($date_debut,$date_fin);
          afficher_taches($date_debut,$date_fin);
          
    }
    
 }

function no_projet_defaut(){
    $request="SELECT no_projet FROM projet WHERE login='".$_SESSION['login']."' AND titre_proj='defaut'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());  
        $DATA=mysql_fetch_object($connexion);
        echo $DATA->no_projet;
}


function menu_activite(){
        echo "<ul><li class='centrale_menu_ajout'><img src='vue/images/ajout_activite.png' alt='act'>  <a href=\"#\" onclick=\"Effect.toggle('toggle_new', 'appear'); return false;\">Ajouter une activit&eacute;</a></li>  <li><img src='vue/images/supprimer.png' alt='supp'>  <a id='supprimer_activite' href='action.php?source=activite&operation=supprimer'>Supprimer la/les activit&eacute(s) s&eacute;lectionn&eacute;e</a></li></ul>";
    }

    $_SESSION['affichage']="activite";

/* DEFINITION DU FICHIER "VUE" ASSOCIE A CE FICHIER */
include_once 'vue/activite.php';



?>