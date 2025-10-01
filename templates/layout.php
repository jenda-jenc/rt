<?php
$pageTitle = $page['title'] ?? 'Riko Klub';
$description = $page['content'] ?? 'Hudební klub v srdci města.';
?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($pageTitle) ?> – Riko Klub</title>
    <meta name="description" content="<?= htmlspecialchars(strip_tags($description)) ?>" />
    <link rel="stylesheet" href="/assets/css/main.css" />
</head>
<body>
<header>
    <div class="container">
        <nav class="nav" aria-label="Hlavní navigace">
            <div class="brand">
                <div class="logo" aria-label="Riko Music Club">
                    <img src="/assets/img/logo.svg" alt="Riko Music Club" />
                </div>
            </div>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobileMenu">Menu</button>
            <div class="links">
                <a href="/">Domů</a>
                <a href="/#program">Program</a>
                <a href="/galerie">Galerie</a>
                <a href="/#kontakt">Kontakt</a>
            </div>
        </nav>
        <div class="mobile-menu" id="mobileMenu" hidden>
            <a href="/">Domů</a>
            <a href="/#program">Program</a>
            <a href="/galerie">Galerie</a>
            <a href="/#kontakt">Kontakt</a>
        </div>
    </div>
</header>

<main>
    <?= $content ?>
</main>

<footer>
    <div class="container">© <span id="y"></span> Riko Klub. Všechna práva vyhrazena.</div>
</footer>

<script src="/assets/js/app.js"></script>
</body>
</html>
