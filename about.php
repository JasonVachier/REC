<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Démarre la session seulement si elle n'est pas déjà démarrée
}

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy(); // Détruit la session
    header("Location: index.php", true, 303); // Redirige vers la page d'accueil après déconnexion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script> <!-- Ajoutez defer ici -->
    <title>About - Renewable Energy Club</title>
</head>
<body>
    <nav class="nav-header">
        <img class="icon" src="image/logo/logo.png">
        <button class="menu-toggle" aria-label="Toggle menu">
            <span class="menu-icon">☰</span> <!-- Icône de menu -->
        </button>
        
        <div class="nav-links">
            <a class="header-link" href="index.php">Home</a>
            <a class="header-link" href="about.php">About</a> <!-- Mettez à jour le lien ici -->
            <a class="header-link" href="WRE.html">Why Renewable Energy</a>
            <a class="header-link" href="articles.php">Article</a>
            <a class="header-link" href="leadership.html">Leadership</a>
        </div>

        <div style="margin-left: auto; text-align: right;">
            <?php if (isset($_SESSION['username'])): ?>
                <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="?logout=true" class="header-link" style="margin-left: 10px;">logout</a>
            <?php else: ?>
                <a href="login.html" class="header-link" style="margin-left: 10px;">login</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="static-background">
        <section class="text-block mission">
            <h2>Mission</h2>
            <br>
            <p>Our mission is to support the next generation of talent in the renewable energy / clean energy space within the NYU community</p>
            <img src="image/Green.jpg">
        </section>

        <section class="text-block about">
            <h2>About</h2>
            <br>
            <p>Join a community of students curious about the energy transition and receive mentorship on career opportunities in the space</p>
            <img src="image/NYU.jpg">
        </section>

        <section class="text-block what-it-means">
            <h2>What it Means for You</h2>
            <br>
            <p>- Ride the tide in a fast-growing industry promising ample job opportunities and deal flow <br><br>- Explore various business models and technologies across the energy transition landscape <br><br>- Contribute to humanity's greatest effort in reversing the negative effects of industrialization
            </p>
        </section>
    </main>
    <footer>
        <p>
            <a href="mailto:renewable-energy-club@nyu.edu">Contact us</a>
            <br>
            New York, NY, USA
        </p>
    </footer>
    
    <script src="script.js"></script>
</body>
</html>
