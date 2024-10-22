<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Échappement des données pour éviter les erreurs SQL
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Remplacer les balises img avec le bon lien
    $dom = new DOMDocument();
    @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $images = $dom->getElementsByTagName('img');

    foreach ($images as $img) {
        $imageFile = $_FILES['image']['tmp_name'];
        if ($imageFile) {
            // Préparer les données pour l'upload
            $data = [
                'image' => new CURLFile($imageFile)
            ];
            $ch = curl_init('upload-image.php'); // URL de votre script upload-image.php
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($response, true);
            if (isset($responseData['url'])) {
                // Remplacez la src de l'image par l'URL retournée
                $img->setAttribute('src', $responseData['url']);
            }
        }
    }

    // Obtenez le nouveau contenu avec les liens d'images mis à jour
    $content = $dom->saveHTML();

    // Enregistrement de l'article dans la base de données
    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";

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
    <form action="create-article.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Title :</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label for="content">Content :</label>
            <div id="editor-container" style="height: 300px; border: 1px solid #ccc;"></div>
            <input type="hidden" name="content" id="hidden-content">
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
                    [{ list: 'ordered' }, { list: 'bullet' }],
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
