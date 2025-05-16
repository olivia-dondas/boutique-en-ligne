
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Boutique Bibine</title>
    <script>const baseUrl = '<?= htmlspecialchars($baseUrl ?? '', ENT_QUOTES, 'UTF-8') ?>';</script>
    <script src="<?= htmlspecialchars($baseUrl ?? '') ?>assets/js/auth.js"></script>
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl ?? '') ?>css/style.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <div id="message" style="display:none;"></div> 

        <form id="loginForm">
            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte ? <a href="<?= htmlspecialchars($baseUrl ?? '') ?>auth/showRegisterForm">Inscrivez-vous ici</a>.</p>
    </div>
    
</body>


</html>
