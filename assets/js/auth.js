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
        const response = await fetch("", {
          method: "POST",
          body: formData,
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
          signal: AbortSignal.timeout(5000), // Timeout après 5s
        });

        if (!response.ok)
          throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

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

  // Initialisation sécurisée
  document.addEventListener("DOMContentLoaded", () => {
    try {
      initAuth();
    } catch (error) {
      console.error("Erreur d'initialisation:", error);
    }
  });
})();
