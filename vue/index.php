<?
include 'biblio_form_dyn.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Connexion</title>
        <link rel="stylesheet" media="screen" type="text/css" title="style" href="vue/style.css" />
    </head>
    <body>
        <div id="logo0">
            <img id="logo_img" border="0" src="vue/images/todo1.png" alt="Logo.">
        </div>
        <?
        //Test si on vient de se connecter ou pas
        if ($connecte == 1) {
            //Afficher le message de confirmation
            ?>
            <div id="logged">
            <?
            echo 'Bienvenue '.$login.'. <a href="projet.php">Cliquez ici pour continuer.</a>';
            ?>
            </div>
            <?
        }
        else {
            ?>
            <div id="login">
                <div id="login_header">
                    Authentification
                </div>
                <?
                //Formulaire de connexion
                form_begin("login", "post", "index.php");
                form_input_text("Login ", "login");
                form_input_password("Mot de passe ", "password");
                form_input_submit("Connexion");
                form_end();
            
                echo '<br>Pas inscrit ? <a href="inscription.php">Enregistrez-vous ici</a>';
                ?>
            </div>
            <div id="footer_admin">
               <a href="admin.php">Administration</a>
            </div>
            <?
        }
        ?>
    </body>
</html>
