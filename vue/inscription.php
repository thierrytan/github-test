<?
include 'biblio_form_dyn.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>S'enregistrer</title>
        <link rel="stylesheet" media="screen" type="text/css" title="style" href="vue/style.css" />
    </head>
    <body>
        <div id="logo0">
            <img id="logo_img" border="0" src="vue/images/todo1.png" alt="Logo.">
        </div>
        <?
        if ($confirm == 0) {
            echo "<div id='login'>";
                echo"<div id='login_header'>
                    Inscription
                </div>";
                //Formulaire d'enregistrement
                form_begin("inscription", "post", "inscription.php");
                form_input_text("Login ", "login");
                form_input_password("Mot de passe ", "password");
                form_input_text("Email ", "email");
                form_input_submit("Enregistrer");
                form_end();
            echo "</div>";
        }
        if ($confirm == 1) {
            echo "<div id='login'>";
                echo "Enregistré.";
            echo "</div>";
        }
        ?>
        <div id="footer_admin">
            <a href="index.php">Retour à la page de connexion</a>
        </div>
    </body>
</html>
