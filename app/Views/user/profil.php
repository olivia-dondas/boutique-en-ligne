<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil - Boutique Bibine</title>
    <link rel="stylesheet" href="<?= isset($baseUrl) ? htmlspecialchars($baseUrl) : '' ?>css/styles.css">
</head>
<body>
    <div class="container">
        <?php if (isset($user) && is_array($user) && !empty($user)): ?>
            <h2>Bienvenue sur votre Profil, <?= htmlspecialchars($user['first_name'] ?? 'Utilisateur') ?> !</h2>
            <p>Votre ID utilisateur : <?= htmlspecialchars($user['id'] ?? 'N/A') ?></p>
            <p>Votre email : <?= htmlspecialchars($user['email'] ?? 'N/A') ?></p>
            <p>Votre rôle : <?= htmlspecialchars($user['role'] ?? 'N/A') ?></p>
        <?php else: ?>
            <h2>Profil Utilisateur</h2>
            <p>Impossible de charger les informations de l'utilisateur. Veuillez vous reconnecter.</p>
        <?php endif; ?>
        
        <p><a href="<?= isset($baseUrl) ? htmlspecialchars($baseUrl) : '' ?>auth/logout">Se déconnecter</a></p>
    </div>
</body>
</html>
