<?
include 'biblio_form_dyn.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Administration</title>
        <link rel="stylesheet" media="screen" type="text/css" title="style" href="vue/style.css" />
    </head>
    <body>
        <div id="logo0">
            <img id="logo_img" border="0" src="vue/images/todo1.png" alt="Logo.">
        </div>
        <div id="header_admin">
            Administration
        </div>
        <div id="liste_utilisateur">
            <div id="liste_utilisateur_header">
                Liste des utilisateurs :
            </div>
            <?    
            //Affichage des utilisateurs
            foreach ($listeUtilisateur as $objetUser) {                
                ?>            
                <ul id="user">
                    <li id="user_login"><?printf("<a href='admin_utilisateur.php?utilisateur=%s'>%s</a>",$objetUser->getLogin(),$objetUser->getLogin());?></li>
                    <li id="user_email"><?printf("%s",$objetUser->getEmail());?></li>
                </ul>                            
                 <?
            }                   
        ?>
        </div>
        <div id="footer_admin">
            <a href="index.php">Retour à la page de connexion</a>
        </div>
    </body>
</html>
