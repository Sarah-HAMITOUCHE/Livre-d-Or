<?php
session_start();
require_once("./classes/user.php");
// Détruire toutes les variables de session
$_SESSION = array();

// Si vous souhaitez détruire complètement la session, effacez également le cookie de session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalement, détruire la session.
session_destroy();

// Rediriger vers la page de connexion ou d'accueil
header("Location: connexion.php");
exit();
?>