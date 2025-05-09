document.addEventListener("DOMContentLoaded", () => {
  const registerForm = document.getElementById("registerForm");
  const messageDiv = document.getElementById("message");

  if (registerForm) {
    registerForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const formData = new FormData(registerForm);
      const submitBtn = registerForm.querySelector('button[type="submit"]');

      submitBtn.disabled = true;
      submitBtn.textContent = "Inscription en cours...";

      try {
        const response = await fetch("", {
          method: "POST",
          body: formData,
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        const data = await response.json();

        messageDiv.textContent = data.message;
        messageDiv.className = data.success ? "success show" : "error show";

        if (data.success) {
          if (data.redirect) {
            window.location.href = data.redirect;
          }
        }
      } catch (error) {
        messageDiv.textContent = "Erreur réseau. Veuillez réessayer.";
        messageDiv.className = "error show";
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = "S'inscrire";
      }
    });
  }
});
