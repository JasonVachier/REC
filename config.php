<?php
$servername = "srv1618.hstgr.io";
$username = "u305296665_JasonVachier"; // utilisateur par défaut de XAMPP
$password = "Jhncjomm13012004."; // mot de passe par défaut de XAMPP
$dbname = "u305296665_REC";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>