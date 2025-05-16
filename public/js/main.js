document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const messageDiv = document.getElementById('message');

    // La variable 'baseUrl' est définie globalement dans les vues login.php et register.php
    // Elle se termine par un '/' ex: http://localhost/votre_projet/public/

    function displayMessage(message, isSuccess) {
        if (messageDiv) {
            messageDiv.textContent = message;
            messageDiv.className = isSuccess ? 'success' : 'error';
            messageDiv.style.display = 'block';
        }
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            if (messageDiv) messageDiv.style.display = 'none';

            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            try {
                // Notez l'URL de l'API
                const response = await fetch(baseUrl + 'auth/processLogin', { // Utilise baseUrl
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data),
                });
                const result = await response.json();
                displayMessage(result.message, result.success);
                if (result.success && result.redirectUrl) {
                    setTimeout(() => { window.location.href = result.redirectUrl; }, 1500);
                }
            } catch (error) {
                console.error('Erreur login AJAX:', error);
                displayMessage('Une erreur de communication est survenue.', false);
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            if (messageDiv) messageDiv.style.display = 'none';

            const formData = new FormData(registerForm);
            const data = Object.fromEntries(formData.entries());

            if (data.password !== data.password_confirm) {
                displayMessage('Les mots de passe ne correspondent pas.', false);
                return;
            }

            try {
                // Notez l'URL de l'API
                const response = await fetch(baseUrl + 'auth/processRegister', { // Utilise baseUrl
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data),
                });
                const result = await response.json();
                displayMessage(result.message, result.success);
                if (result.success) {
                    registerForm.reset();
                    setTimeout(() => { window.location.href = baseUrl + 'auth/showLoginForm'; }, 2000);
                }
            } catch (error) {
                console.error('Erreur register AJAX:', error);
                displayMessage('Une erreur de communication est survenue.', false);
            }
        });
    }
});
