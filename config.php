<?php
$servername = "localhost";
$username = "root"; // utilisateur par défaut de XAMPP
$password = ""; // mot de passe par défaut de XAMPP
$dbname = "REC";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>