<!doctype html>
<html lang="cs">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Administrace – Riko Klub</title>
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link rel="stylesheet" href="/assets/css/admin.css" />
</head>
<body class="admin">
    <header class="admin-header">
        <div class="container">
            <h1>Administrace Riko Klub</h1>
            <nav>
                <a href="/admin">Přehled</a>
                <a href="/admin/logout">Odhlásit se</a>
            </nav>
        </div>
    </header>
    <main class="admin-main">
        <div class="container">
            <?= $content ?>
        </div>
    </main>
</body>
</html>
