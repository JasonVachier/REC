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
    <title>Articles - Renewable Energy Club</title>
    <link rel="stylesheet" href="style.css"> <!-- Change le nom de fichier ici -->
</head>
<body>

    <nav class="nav-header">
        <img class="icon" src="image/logo/logo.png">
        <a class="header-link" href="index.php">Home</a>
        <a class="header-link" href="about.html">About</a>
        <a class="header-link" href="WRE.html">Why Renewable Energy</a>
        <a class="header-link active" href="articles.php">Articles</a>
        <a class="header-link" href="leadership.html">Leadership</a>
        <div style="margin-left: auto; text-align: right;">
            <?php if (isset($_SESSION['username'])): ?>
                <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="header-link" style="margin-left: 10px;">Déconnexion</a>
            <?php else: ?>
                <a href="login.html" class="header-link" style="margin-left: 10px;">Connexion</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="static-background"> 
        <div class="content">
            <h1>Liste des Articles</h1>

            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="article-block"> <!-- Classe ajoutée ici -->
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

            <?php if (isset($_SESSION['username'])): ?>
                <a href="dashboard.php">Retour au tableau de bord</a>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>
            <a href="mailto:renewable-energy-club@nyu.edu">Contact us</a>
            <br>
            New York, NY, USA
        </p>
    </footer>

</body>
</html>

<?php
$conn->close(); // Ferme la connexion à la base de données
?>
