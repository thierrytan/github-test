<?            
    //Si aucune session, redirection direct à la page de login
    if (!isset($_SESSION['login'])) {
          header("Location: index.php");
    }
?>
