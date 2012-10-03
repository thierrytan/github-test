<?
include 'biblio_form_dyn.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Administration utilisateur</title>
        <link rel="stylesheet" media="screen" type="text/css" title="style" href="vue/style.css" />
        <script type="text/javascript">
            function test(id){
                document.getElementById("supprimer").href=document.getElementById("supprimer").href+"&projet"+id+"="+id;
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
        <div id="logo0">
            <img id="logo_img" border="0" src="vue/images/todo1.png" alt="Logo.">
        </div>
               
        <div id='admin_utilisateur'>
<div id="login_header">
            Gestion d'un utilisateur
        </div> <?
            printf("Nom de l'utilisateur : %s<br><br>",$utilisateur->getLogin());
            printf("Adresse email : %s<br><br>",$utilisateur->getEmail());
            printf("Nombre de projets : %s<br>",$nbProjet[0]);
            printf("Nombre d'activit&eacute;s : %s<br>",$nbActivite[0]);
            printf("Nombre de sous-activit&eacute;s : %s<br>",$nbTache[0]);
            printf("Nombre d'activit&eacute;s au total : %s",$nbTotal);?>
        </div> 
        <div id="footer_admin">
            <a href='admin.php'>Retour a l'administration</a>
        </div>
        <div id="admin_afficher_activite">
            <?afficher_activite($login);?>
        </div>
    </body>
</html>
