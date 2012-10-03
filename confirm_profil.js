function confirm_email(formulaireEmail) {
    var message = "";
    if (formulaireEmail.email.value == "") {
        message = "Entrez un email. ";
    }
    if (message == "") {
        message = "Email mise à jour.";
    }
    alert(message);
}


function confirm_password(formulairePassword,pass) {
    var message = "";
    if ((formulairePassword.pass2.value == "")||(formulairePassword.pass3.value == "")) {
        message = message+"Entrez un mot de passe.";
    }
    if (formulairePassword.pass2.value != formulairePassword.pass3.value) {
        message = message+"Les 2 mots de passe entrés ne sont pas identiques.";
    }
    if (formulairePassword.pass1.value != formulairePassword.pass.value) {
        message = message+"Mauvais ancien mot de passe.";
    }
    if (message == "") {
        message = "Mot de passe mise à jour.";
    }
    alert(message);
}


