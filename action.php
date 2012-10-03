<?php

session_start();

$db=mysql_connect("localhost", "root", "root");
mysql_select_db("projet",$db);

$source=$_GET['source'];
$operation=$_GET['operation'];



if($source=='activite')
{
    $no_projet_courant=$_POST['no_projet_courant'];
    $no_activite=$_POST['no_activite'];
    $titre_act=$_POST['activite'];
    $no_projet=$_POST['projet'];
    $note=$_POST['note'];
    $priorite=$_POST['priorite'];
    $etat=$_POST['etat'];
    $jour=$_POST['jour'];
    $mois=$_POST['mois'];
    $annee=$_POST['annee'];
    $login=$_SESSION['login'];
    if($operation=='modification')
    {
        $request="UPDATE activite SET no_projet='$no_projet', titre_act='$titre_act', note='$note', priorite='$priorite', etat='$etat', date='".$annee."-".$mois."-".$jour."' WHERE no_activite='$no_activite' AND login='".$_SESSION['login']."'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    if($operation=='creer')
    {

        $request="INSERT INTO activite(no_activite, no_projet, login, titre_act, note, priorite, etat, date) VALUES ('','$no_projet_courant','$login','$titre_act','$note','$priorite','$etat','".$annee."-".$mois."-".$jour."')";
        //echo $request;
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    if($operation=='supprimer')
    {
        $request="SELECT * FROM activite WHERE login='".$_SESSION['login']."'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $nb_activite=mysql_num_rows($connexion);
        for($n=0;$n<$nb_activite;$n++){
            $DATA=mysql_fetch_object($connexion);
            $no_projet_courant=$DATA->no_projet;
            $max_id=$DATA->no_activite;
            if(isset($_GET['projet'.$max_id])) {
                $request="DELETE FROM activite WHERE login='".$_SESSION['login']."' AND no_activite='$max_id'";
                $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            }
        }
    }
    header("Location:$source.php?projet=$no_projet_courant");
}



if($source=='projet')
{
    $no_projet=$_POST['no_projet'];
    $titre_proj=$_POST['titre_proj'];
    $note=$_POST['note'];
    $couleur=$_POST['couleur'];
    $etat=$_POST['etat'];
    $jour=$_POST['jour'];
    $mois=$_POST['mois'];
    $annee=$_POST['annee'];
    $login=$_SESSION['login'];

    if($operation=='modification')
    {
        $request="UPDATE projet SET titre_proj='$titre_proj', note='$note', couleur='$couleur', etat='$etat', date='".$annee."-".$mois."-".$jour."' WHERE no_projet='$no_projet' AND login='".$_SESSION['login']."'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    if($operation=='creer')
    {

        $request="INSERT INTO projet(no_projet, login, titre_proj, note, date, couleur, etat) VALUES ('','$login','$titre_proj','$note','".$annee."-".$mois."-".$jour."', '$couleur','$etat')";
        //echo $request;
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    if($operation=='supprimer')
    {
        $request="SELECT * FROM projet WHERE login='".$_SESSION['login']."'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $nb_projet=mysql_num_rows($connexion);
        for($n=0;$n<$nb_projet;$n++){
            $DATA=mysql_fetch_object($connexion);
            $max_id=$DATA->no_projet;
            if(isset($_GET['projet'.$max_id])) {
                $request="DELETE FROM projet WHERE login='".$_SESSION['login']."' AND no_projet='$max_id'";
                $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            }
        }  
    }    
    header("Location:$source.php");
}



if($source=='tache')
{
    $no_activite_courante=$_POST['no_activite_courante'];
    $no_tache=$_POST['no_tache'];
    $titre_tache=$_POST['titre_tache'];
    $no_activite=$_POST['no_activite'];
    $note=$_POST['note'];
    $priorite=$_POST['priorite'];
    $etat=$_POST['etat'];
    $jour=$_POST['jour'];
    $mois=$_POST['mois'];
    $annee=$_POST['annee'];
    $login=$_SESSION['login'];
    if($operation=='modification')
    {
        $request="UPDATE tache SET no_activite='$no_activite', titre_tache='$titre_tache', note='$note', priorite='$priorite', etat='$etat', date='".$annee."-".$mois."-".$jour."' WHERE no_tache='$no_tache' AND login='".$_SESSION['login']."'";
        //echo $request;
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    if($operation=='creer')
    {
        
        $request="INSERT INTO tache(no_tache, no_activite, login, titre_tache, note, priorite, etat, date) VALUES ('','$no_activite_courante','$login','$titre_tache','$note','$priorite','$etat','".$annee."-".$mois."-".$jour."')";
        //echo $request;
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    if($operation=='supprimer')
    {
        $request="SELECT * FROM tache WHERE login='".$_SESSION['login']."'";
        $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $nb_tache=mysql_num_rows($connexion);
        for($n=0;$n<$nb_tache;$n++){
            $DATA=mysql_fetch_object($connexion);
            $no_activite_courante=$DATA->no_activite;
            $max_id=$DATA->no_tache;
            if(isset($_GET['projet'.$max_id])) {
                $request1="SELECT * FROM tache WHERE login='".$_SESSION['login']."' AND no_tache='$max_id'";
                $connexion1=mysql_query($request1) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                $DATA_SUPPR=mysql_fetch_object($connexion1);
                $no_activite_courante=$DATA_SUPPR->no_activite;
                $request="DELETE FROM tache WHERE login='".$_SESSION['login']."' AND no_tache='$max_id'";
                $connexion=mysql_query($request) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            }
        }
    }
    header("Location:$source.php?activite=$no_activite_courante");
}
?>
