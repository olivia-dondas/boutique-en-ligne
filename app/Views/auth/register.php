<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Boutique Bibine</title>
    <script>const baseUrl = '<?= htmlspecialchars($baseUrl ?? '', ENT_QUOTES, 'UTF-8') ?>';</script>
    <script src="<?= htmlspecialchars($baseUrl ?? '') ?>assets/js/auth.js"></script>
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl ?? '') ?>css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <div id="message" style="display:none;"></div>
        
        <form id="registerForm">
            <div>
                <label for="first_name">Prénom :</label>
                <input type="text" name="first_name" id="first_name" required>
            </div>
            <div>
                <label for="last_name">Nom :</label>
                <input type="text" name="last_name" id="last_name" required>
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="birth_date">Date de naissance :</label>
                <input type="date" name="birth_date" id="birth_date" required>
            </div>
            <div>
                <label for="address">Adresse :</label>
                <input type="text" name="address" id="address" required>
            </div> 
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" minlength="6" required>
            </div>
            <div>
                <label for="password_confirm">Confirmer le mot de passe :</label>
                <input type="password" name="password_confirm" id="password_confirm" minlength="6" required>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà un compte ? <a href="<?= htmlspecialchars($baseUrl ?? '') ?>auth/showLoginForm">Connectez-vous ici</a>.</p>
    </div>

</body>
</html>
