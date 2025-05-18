// Enrobez tout dans une fonction auto-exécutante pour isoler le scope
(() => {
  // Gestion robuste des erreurs
  const initAuth = () => {
    const registerForm = document.getElementById("registerForm");
    const messageDiv = document.getElementById("message");

    if (!registerForm || !messageDiv) return;

    const handleSubmit = async (e) => {
      e.preventDefault();
      const formData = new FormData(registerForm);
      const submitBtn = registerForm.querySelector('button[type="submit"]');

      // Désactive le bouton
      submitBtn.disabled = true;
      submitBtn.textContent = "Inscription en cours...";

      try {
        const response = await fetch("/boutique-en-ligne/auth/register", {
          method: "POST",
          body: formData,
        });
        const text = await response.text();
        console.log(text); // Pour debug
        const data = JSON.parse(text);

        // Affiche le message
        messageDiv.textContent = data.message;
        messageDiv.className = data.success ? "success show" : "error show";

        // Redirection si succès
        if (data.success && data.redirect) {
          await new Promise((resolve) => setTimeout(resolve, 1500)); // Délai pour lire le message
          window.location.href = data.redirect;
        }
      } catch (error) {
        console.error("Erreur:", error);
        messageDiv.textContent = error.message.includes("timeout")
          ? "Temps écoulé - serveur inaccessible"
          : "Erreur réseau. Veuillez réessayer.";
        messageDiv.className = "error show";
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = "S'inscrire";
      }
    };

    // Nettoyage des listeners avant réattachement
    registerForm.removeEventListener("submit", handleSubmit);
    registerForm.addEventListener("submit", handleSubmit);
  };

  // Gestion de la connexion
  const initLogin = () => {
    const loginForm = document.getElementById("loginForm");
    const messageDiv = document.getElementById("message");

    if (!loginForm || !messageDiv) return;

    const handleLoginSubmit = async (e) => {
      e.preventDefault();
      const formData = new FormData(loginForm);
      const submitBtn = loginForm.querySelector('button[type="submit"]');

      // Désactive le bouton
      submitBtn.disabled = true;
      submitBtn.textContent = "Connexion en cours...";

      try {
        const response = await fetch("/boutique-en-ligne/auth/login", {
          method: "POST",
          body: formData,
        });
        const text = await response.text();
        console.log(text); // Pour debug
        const data = JSON.parse(text);

        // Affiche le message
        messageDiv.textContent = data.message;
        messageDiv.className = data.success ? "success show" : "error show";

        // Redirection si succès
        if (data.success && data.redirect) {
          await new Promise((resolve) => setTimeout(resolve, 1500)); // Délai pour lire le message
          window.location.href = data.redirect;
        }
      } catch (error) {
        console.error("Erreur:", error);
        messageDiv.textContent = error.message.includes("timeout")
          ? "Temps écoulé - serveur inaccessible"
          : "Erreur réseau. Veuillez réessayer.";
        messageDiv.className = "error show";
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = "Se connecter";
      }
    };

    // Nettoyage des listeners avant réattachement
    loginForm.removeEventListener("submit", handleLoginSubmit);
    loginForm.addEventListener("submit", handleLoginSubmit);
  };

  // Initialisation sécurisée
  document.addEventListener("DOMContentLoaded", () => {
    try {
      initAuth();
      initLogin();
    } catch (error) {
      console.error("Erreur d'initialisation:", error);
    }
  });
})();
