document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const errorContainer = document.createElement("p");
    const successContainer = document.createElement("p");
  
    errorContainer.style.color = "red";
    successContainer.style.color = "green";
  
    form.prepend(errorContainer);
    form.prepend(successContainer);
  
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
  
      errorContainer.textContent = "";
      successContainer.textContent = "";
  
      const email = form.email.value.trim();
      const csrfToken = form.csrf_token.value;
  
      if (!email) {
        errorContainer.textContent = "Veuillez saisir votre adresse email.";
        return;
      }
  
      try {
        const data = await secureFetch("/api/auth/forgotPassword", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ email }),
        });
        
        if (data.success) {
          successContainer.textContent = data.message || "Un email de réinitialisation a été envoyé si l'adresse est enregistrée.";
          form.reset();
        } else {
          errorContainer.textContent = data.error || "Une erreur est survenue.";
        }
      } catch (err) {
        errorContainer.textContent = err.message;
      }
    });
  });
  