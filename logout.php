<?php
session_start();
session_destroy(); // Détruire la session

// Vérifier la page d'origine
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);

    // Si la page d'origine est dashboard.php, rediriger vers index.html
    if ($referer === '/REC/dashboard.php') { // Assure-toi que le chemin correspond bien
        header("Location: index.html");
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Renvoyer à la page d'origine
    }
} else {
    header("Location: index.php"); // Rediriger vers index.html par défaut
}

exit(); // Terminer le script
?>