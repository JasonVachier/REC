<?php
session_start();
include('config.php'); // Assure-toi que ce fichier est correctement inclus

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = null;

    // Gestion du téléchargement de fichier
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $image = basename($_FILES['image']['name']);
        $upload_file = $upload_dir . $image;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Vérifie si le téléchargement a réussi
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            echo "Erreur lors du téléchargement de l'image.";
            exit();
        }
    }

    // Enregistrement de l'article dans la base de données
    $sql = "INSERT INTO posts (title, content, image) VALUES ('$title', '$content', '$image')";

    // Exécutez la requête et gérez les erreurs
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error; // Affiche l'erreur
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rédiger un nouvel article</title>
    <link rel="stylesheet" href="stylephp.css">
</head>
<body>
    <h1>Rédiger un nouvel article</h1>
    <form action="create_post.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Titre :</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label for="content">Contenu :</label>
            <textarea name="content" required></textarea>
        </div>
        <div>
            <label for="image">Télécharger une image :</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; font-size: 16px;">Publier l'article</button>
        </div>
    </form>
    <div style="text-align: center; margin-top: 20px;">
        <a href="dashboard.php">Retour au tableau de bord</a>
    </div>
</body>
</html>
