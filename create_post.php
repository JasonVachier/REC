<?php
session_start();
include('config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Protection contre les injections SQL
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
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

    // Exécute la requête et gère les erreurs
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
    <title>Write a new article</title>
    <script src="https://cdn.tiny.cloud/1/y14s5trv0axwjl7n9b0040erhn7e625twf5fc3jopaz2cy4y/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            menubar: false,
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
    </script>
    <link rel="stylesheet" href="stylephp.css">
</head>
<body>
    <h1>Write a new article</h1>
    <form action="create_post.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Title :</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label for="content">Content :</label>
            <textarea name="content" required></textarea>
        </div>
        <div>
            <label for="image">Upload an image :</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; font-size: 16px;">Publish the article</button>
        </div>
    </form>
    <div style="text-align: center; margin-top: 20px;">
        <a href="dashboard.php">Back to dashboard</a>
    </div>
</body>
</html>
