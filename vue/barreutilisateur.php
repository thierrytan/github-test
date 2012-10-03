<!--La barre utilisateur est en fait une liste alignée par CSS--> 
<div id="header">
    <ul id="usertoolbar1">
        <li id="toolbar_login1"><?printf("<img src='vue/images/profil.png' alt='profil'>  <a href='projet.php'>%s</a>",$login);?></li>
        <li id="toolbar_info1"><img src='vue/images/gerer.png' alt='gerer'>  <a href="profil.php">G&eacute;rer profil</a></li>
        <li id="toolbar_logout1"><img src='vue/images/deconnecte.png' alt='deconnecte'>  <a href="index.php?logout=1">D&eacute;connexion</a></li>
    </ul>
    <div id="logo">
        <img id="logo_img" border="0" src="vue/images/todo1.png" alt="Logo.">
    </div>
</div>