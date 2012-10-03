<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;" charset="iso-8859-1">


        <?php
                if($_SESSION['affichage']=="activite") echo "<title>Activit&eacute;s</title>";

                if($_SESSION['affichage']=="projet") echo "<title>Projet</title>";
                if($_SESSION['affichage']=="tache") echo "<title>T&acirc;che</title>";
        ?>
        <script type="text/javascript">
            function test(id){
                if(document.getElementById(id).name=="projet"){
                    if(document.getElementById(id).checked==true){
                        document.getElementById("supprimer_projet").href=document.getElementById("supprimer_projet").href+"&projet"+id+"="+id;
                    }
                    if(document.getElementById(id).checked==false){
                        var url=document.getElementById("supprimer_projet").href;
                        var suppr="&projet"+id+"="+id;
                        document.getElementById("supprimer_projet").href=document.getElementById("supprimer_projet").href.replace(suppr,"");
                    }
                }
                if(document.getElementById(id).name=="activite"){
                    if(document.getElementById(id).checked==true){
                        document.getElementById("supprimer_activite").href=document.getElementById("supprimer_activite").href+"&projet"+id+"="+id;
                    }
                    if(document.getElementById(id).checked==false){
                        var url=document.getElementById("supprimer_activite").href;
                        var suppr="&projet"+id+"="+id;
                        document.getElementById("supprimer_activite").href=document.getElementById("supprimer_activite").href.replace(suppr,"");
                    }
                }
                if(document.getElementById(id).name=="tache"){
                    if(document.getElementById(id).checked==true){
                        document.getElementById("supprimer_tache").href=document.getElementById("supprimer_tache").href+"&projet"+id+"="+id;
                    }
                    if(document.getElementById(id).checked==false){
                        var url=document.getElementById("supprimer_tache").href;
                        var suppr="&projet"+id+"="+id;
                        document.getElementById("supprimer_tache").href=document.getElementById("supprimer_tache").href.replace(suppr,"");
                    }
                }

            }
        </script>
        <link rel="stylesheet" media="screen" type="text/css" title="style" href="vue/style.css" />
        <script src="javascripts/prototype.js" type="text/javascript"></script>
        <script src="javascripts/scriptaculous.js" type="text/javascript"></script>
        <script src="javascripts/unittest.js" type="text/javascript"></script>
        <script src="javascripts/effects.js" type="text/javascript"></script>
        <script src="javascripts/builder.js" type="text/javascript"></script>
        <script src="javascripts/controls.js" type="text/javascript"></script>
        <script src="javascripts/dragdrop.js" type="text/javascript"></script>
        <script src="javascripts/slider.js" type="text/javascript"></script>
        <script src="javascripts/sound.js" type="text/javascript"></script>
    </head>
    <body>
        <?include_once 'vue/barreutilisateur.php';?>
        <div class="corps">
        <div class="menu">
            <ol>
                <li><a href="activite.php?projet=<?php echo no_projet_defaut(); ?>">Projet <i>d&eacute;faut</i></a></li>
                <li><a href="projet.php">Mes Projets</a></li>
                <hr>
                <li><a href="activite.php?date=<?php echo date("Y-m-d"); ?>">Aujourd'hui</a></li>
                <li><a href="activite.php?date=<?php echo date("Y-m-d"); ?>&tard=oui">Plus tard</a></li>
                <li><a href="activite.php?interval=oui">Plage de date</a></li>
                <li><a href="activite.php?date=<?php echo date("Y-m-d"); ?>&retard=oui">En retard !</a></li>
                <hr>
                <li><a href="activite.php?etat=fait">T&acirc;ches r&eacute;alis&eacute;es</a></li>
            </ol>
        </div>
        <div class="centrale">
            <div class="centrale_header"><?
                if ($_SESSION['affichage'] == "projet") { 
                    echo "Projets";
                }
                
                if ($_GET['tard'] == "oui") { 
                    echo "Plus tard (7 prochains jours)";
                }
                
                if ($_GET['etat'] == "fait") { 
                    echo "T&acirc;ches r&eacute;alis&eacute;es";
                }
                
                if ($_GET['retard'] == "oui") { 
                    echo "T&acirc;ches en retard";
                }
                
                if (isset($_GET['projet'])) { 
                    echo "T&acirc;ches";
                }
                
                if (isset($_GET['activite'])) { 
                    echo "T&acirc;ches";
                }
                
                if (isset($_GET['interval'])) { 
                    echo "Recherche par plage de date";
                }
                
                if (isset($_GET['date'])&&!isset($_GET['tard'])&&!isset($_GET['retard'])) { 
                    echo "Aujourd'hui";
                }?>
            </div>
            <?php
            if ($_SESSION['affichage'] == "activite" && $_SESSION['menu'] == "oui") {
                echo "<div class='centrale_menu'>";
                menu_activite();
                echo "</div>";
            }
            if ($_SESSION['affichage'] == "projet") {
                echo "<div class='centrale_menu'>";
                menu_projet();
                echo "</div>";
            }
            if ($_SESSION['affichage'] == "tache") {
                echo "<div class='centrale_menu'>";
                menu_tache();
                echo "</div>";
            }
            ?>
            <?php
            if ($_SESSION['affichage'] == "activite")
                afficher_activite();
            if ($_SESSION['affichage'] == "projet")
                afficher_projet();
            if ($_SESSION['affichage'] == "tache")
                afficher_tache();
            ?>
        </div>
        </div>
    </body>
</html>
