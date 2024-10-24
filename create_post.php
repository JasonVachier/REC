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

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            echo "Erreur lors du téléchargement de l'image.";
            exit();
        }
    }

    // Enregistrement de l'article dans la base de données
    $sql = "INSERT INTO posts (title, content, image) VALUES ('$title', '$content', '$image')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Write a new article</title>
    <link rel="stylesheet" href="stylephp.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
</head>
<body>
    <h1>Write a new article</h1>
    <form action="create_post.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Title :</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <div id="editor-container" style="height: 300px; border: 1px solid #ccc;"></div>
            <input type="hidden" name="content" id="hidden-content">
        </div>
        <div>
            <label for="image">Upload an image :</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <button type="submit">Publish the article</button>
        </div>
    </form>
    <div style="text-align: center; margin-top: 20px;">
        <a href="dashboard.php">Back to dashboard</a>
    </div>

    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote', 'code-block'],
                    [{ script: 'sub' }, { script: 'super' }],
                    [{ align: [] }],
                    ['link', 'image']
                ]
            }
        });

        document.querySelector('form').onsubmit = function() {
            document.querySelector('#hidden-content').value = quill.root.innerHTML;
        };
    </script>
</body>
</html>
