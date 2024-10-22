<?php
// upload_image.php

$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Réponse JSON par défaut
$response = ['success' => false];

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
        $response['error'] = "Type de fichier non autorisé. Seuls les formats JPG, PNG et GIF sont acceptés.";
    } else {
        $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $imageName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $response['success'] = true;
            $response['url'] = $uploadFile;
        } else {
            $response['error'] = "Erreur lors du téléchargement de l'image.";
        }
    }
} else {
    $response['error'] = "Aucun fichier téléchargé ou une erreur s'est produite.";
}

// Retourner la réponse en JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
