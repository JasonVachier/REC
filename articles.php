<?php
session_start();
include('config.php');

// Requête pour récupérer tous les articles
$sql = "SELECT * FROM posts ORDER BY created_at DESC"; // Tri par date de création, du plus récent au plus ancien
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link rel="stylesheet" href="stylephp.css"> <!-- Ajoute ton fichier CSS ici -->
</head>
<body>
    <!-- Exemple d'icône de connexion dans l'en-tête -->
    <div style="text-align: right; margin: 10px;">
        <?php if (isset($_SESSION['username'])): ?>
            <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" style="margin-left: 10px;">Déconnexion</a>
        <?php else: ?>
            <a href="login.html">Connexion</a>
        <?php endif; ?>
    </div>

    <h1>Liste des Articles</h1>

    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo htmlspecialchars($row['content']); ?></p>
                    <?php if ($row['image']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Image de l'article" style="max-width: 100%; height: auto;">
                    <?php endif; ?>
                    <p><em>Publié le <?php echo $row['created_at']; ?></em></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>

    <a href="dashboard.php">Retour au tableau de bord</a>
</body>
</html>

<?php
$conn->close(); // Ferme la connexion à la base de données
?>
