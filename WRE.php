<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Démarre la session seulement si elle n'est pas déjà démarrée
}

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy(); // Détruit la session
    header("Location: WRE.php", true, 303); // Redirige vers la page d'accueil après déconnexion
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
    <title>WRE - Renewable Energy Club</title>
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
            <a class="header-link" href="WRE.php">Why Renewable Energy</a>
            <a class="header-link" href="articles.php">Blog</a>
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

        <div class="content">
            <h2>Contribute to the Energy Transition</h2>
            <h3>The Biggest Challenge and Opportunity of Our Lifetime</h3>

        </div>

        <section class="text-block Industry">
            <h2>Rapidly Expanding Industry</h2>
            <div class="text-image">
                <p>Favored by policies such as the Inflation Reduction Act <a href="https://home.treasury.gov/policy-issues/inflation-reduction-act">(IRA)</a> and the Bipartisan Infrastructure Act, the clean energy space is rapidly expanding in the US, attracting investments, renewable projects, and thus, job opportunities</p>
                <img src="image/SolarPanel.jpg" alt="Solar Panel">
            </div>
        </section>

        <section class="text-block Intellec">
            <h2>Intellectually Stimulating</h2>
            <div class="text-image">
                <p>The ever-changing renewable energy space encompasses various technologies (solar, wind, biofuel, clean hydrogen), as well as business models</p>
                <img src="image/work.jpg" alt="Work">
            </div>
        </section>

        <section class="text-block Impactful">
            <h2>Impactful</h2>
            <div class="text-image">
                <div class="impact-text">
                    <h3>Environmental</h3>
                    <p>- 80% of carbon emissions are generated directly or indirectly from energy sources. Thus, decarbonizing our energy sector will maximize our efforts in fighting against global warming</p>
                    <h3>Economic</h3>
                    <p>- The energy sector attracts investments to strengthen a region's infrastructure, industrial, and manufacturing backbone, leading to high-quality job creation</p>
                    <h3>Political</h3>
                    <p>- Energy is the pillar of society. Amidst global economic challenges, political tensions, and global warming, countries around the world urgently seek to support economic development, supply chain independence, and decarbonization in the energy sector</p>
                </div>
                <img src="image/world.jpg" alt="World">
            </div>
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
