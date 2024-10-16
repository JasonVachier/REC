<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_POST['current_image']; // Conserve l'image actuelle par défaut

    // Gestion de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $image = basename($_FILES['image']['name']);
        $upload_file = $upload_dir . $image;

        // Vérifie si le dossier d'upload existe, sinon le crée
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Vérifie si le téléchargement a réussi
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            echo "Erreur lors du téléchargement de l'image.";
            exit();
        }
    } elseif (isset($_POST['remove_image'])) {
        $image = null; // Retire l'image
    }

    // Met à jour l'article dans la base de données
    $sql = "UPDATE posts SET title = '$title', content = '$content', image = '$image' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erreur : " . $conn->error;
    }
} else {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM posts WHERE id = $id";
    $result = $conn->query($sql);
    $post = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article</title>
    <link rel="stylesheet" href="stylephp.css">
</head>
<body>
    <h1>Modifier l'article</h1>
    <form action="edit_article.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        <div>
            <label for="title">Titre :</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        <div>
            <label for="content">Contenu :</label>
            <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>
        <div>
            <label for="image">Télécharger une nouvelle image :</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <?php if ($post['image']): ?>
            <div>
                <h4>Image actuelle :</h4>
                <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Image de l'article" style="max-width: 200px;">
                <p>Voulez-vous supprimer l'image actuelle ?</p>
                <input type="checkbox" name="remove_image" value="1"> Oui, supprimer l'image
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; font-size: 16px;">Mettre à jour l'article</button>
        </div>
    </form>
    <div style="text-align: center; margin-top: 20px;">
        <a href="dashboard.php">Retour au tableau de bord</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>