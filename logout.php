<?php
session_start();
session_destroy(); // Détruire la session

// Vérifier la page d'origine et rediriger
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);

    // Si la page d'origine est une page d'utilisateur, rediriger vers index.html
    if (strpos($referer, 'user_page.php') !== false) { // Remplace 'user_page.php' par le nom réel de ta page d'utilisateur
        header("Location: index.html");
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Renvoyer à la page d'origine
    }
} else {
    header("Location: index.html"); // Rediriger vers index.html par défaut
}

exit();
?>