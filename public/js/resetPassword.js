document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const errorContainer = document.createElement('p');
    errorContainer.style.color = 'red';
    form.parentNode.insertBefore(errorContainer, form);
  
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      errorContainer.textContent = '';
  
      const password = form.password.value.trim();
      const passwordConfirm = form.password_confirm.value.trim();
      const csrfToken = form.csrf_token.value;
      const token = form.token.value;
  
      if (!password || password.length < 8) {
        errorContainer.textContent = "Le mot de passe doit contenir au moins 8 caractères.";
        return;
      }
      if (password !== passwordConfirm) {
        errorContainer.textContent = "Les mots de passe ne correspondent pas.";
        return;
      }
      if (!token) {
        errorContainer.textContent = "Le token de réinitialisation est manquant ou invalide.";
        return;
      }
  
      try {
        const response = await secureFetch('/api/auth/resetPassword', {
          method: 'POST',
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            token,
            password: password,
          }),
        });
  
        if (response.success) {
          form.innerHTML = '<p style="color:green;">Mot de passe réinitialisé avec succès ! Vous pouvez maintenant vous connecter.</p>';
        } else {
          errorContainer.textContent = response.message || "Erreur lors de la réinitialisation du mot de passe.";
        }
      } catch (err) {
        console.error("Erreur lors de la requête pour reinitialiser le mot de passe :", err);
        errorContainer.textContent = "Erreur serveur, veuillez réessayer plus tard.";
      }
    });
  });
  