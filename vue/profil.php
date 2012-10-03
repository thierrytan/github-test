<?
include 'biblio_form_dyn.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Profil</title>
        <link rel="stylesheet" media="screen" type="text/css" title="style" href="vue/style.css" />
        <script type="text/javascript" src="confirm_profil.js"></script>
    </head>
    <body>
        <?
        include_once 'vue/barreutilisateur.php';
        
        //Formulaire modification du mot de passe
        ?>
        <div class="corps">
        
        <div id='profil'>
            <div id="profil_header">
                Gestion du profil
            </div>
            <br>Modifier le mot de passe :<br><br><?
            
            form_begin("formulairePassword", "post", "profil.php");               
            form_input_password("Ancien mot de passe", "pass1","30");
            form_input_password("Nouveau mot de passe", "pass2","30");
            form_input_password("Confirmer le mot de passe", "pass3","30");
            form_hidden("pass", $pass);
            echo "<input type='submit' value='Sauvegarder' onClick ='confirm_password(formulairePassword,pass)'/>";    
            form_end();
        
            //Formulaire modification de l'adresse email
            echo "<br>Modifier l'adresse email :<br><br>";
            printf ("Email actuel : <i>%s</i><br>", $user->getEmail());
            form_begin("formulaireEmail", "post", "profil.php");
            form_input_text("Nouvel email", "email","40","");
            echo "<input type='submit' value='Sauvegarder' onClick ='confirm_email(formulaireEmail)'/>";
            form_end();?>
        </div>
        </div>
        
    </body>
</html>
