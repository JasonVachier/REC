<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $image = basename($_FILES['image']['name']);
        $upload_file = $upload_dir . $image;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            // Retourner l'URL de l'image ou la balise HTML à insérer
            echo json_encode(['url' => $upload_file]);
        } else {
            echo json_encode(['error' => 'Erreur lors du téléchargement de l\'image.']);
        }
    } else {
        echo json_encode(['error' => 'Aucune image téléchargée.']);
    }
} else {
    echo json_encode(['error' => 'Méthode non autorisée.']);
}
?>
