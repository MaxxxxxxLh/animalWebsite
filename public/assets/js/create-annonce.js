document.addEventListener("DOMContentLoaded", function () {
  // Aperçu des images avant upload
  const photosInput = document.getElementById("photos");
  const previewContainer = document.getElementById("previewContainer");

  if (photosInput) {
    photosInput.addEventListener("change", function (e) {
      previewContainer.innerHTML = "";

      const files = e.target.files;
      const maxFiles = 3;

      if (files.length > maxFiles) {
        alert(`Vous ne pouvez sélectionner que ${maxFiles} photos maximum.`);
        this.value = "";
        return;
      }

      for (let i = 0; i < Math.min(files.length, maxFiles); i++) {
        const file = files[i];
        if (file.type.match("image.*")) {
          const reader = new FileReader();

          reader.onload = function (e) {
            const img = document.createElement("img");
            img.src = e.target.result;
            img.classList.add("preview-image");
            previewContainer.appendChild(img);
          };

          reader.readAsDataURL(file);
        }
      }
    });
  }

  // Validation du formulaire
  const annonceForm = document.getElementById("annonceForm");

  if (annonceForm) {
    annonceForm.addEventListener("submit", function (e) {
      e.preventDefault(); // Empêcher la soumission par défaut

      const titre = document.getElementById("titre").value;
      const date = document.getElementById("date").value;

      if (titre.length < 10) {
        alert("Le titre doit contenir au moins 10 caractères");
        return;
      }

      const selectedDate = new Date(date);
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      if (selectedDate < today) {
        alert("La date doit être aujourd'hui ou dans le futur");
        return;
      }

      // Créer un objet FormData pour envoyer les données
      const formData = new FormData(annonceForm);

      // Envoyer les données via fetch
      fetch("/cree-annonces/store", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Afficher la popup de confirmation
            const result = confirm(
              "Votre annonce a été créée avec succès ! Voulez-vous voir toutes les annonces ?"
            );
            if (result) {
              // Rediriger vers la page des annonces
              window.location.href = "/annonces";
            } else {
              // Réinitialiser le formulaire pour une nouvelle annonce
              annonceForm.reset();
              previewContainer.innerHTML = "";
            }
          } else {
            alert(
              "Une erreur est survenue lors de la création de l'annonce. Veuillez réessayer."
            );
          }
        })
        .catch((error) => {
          console.error("Erreur:", error);
          alert(
            "Une erreur est survenue lors de la création de l'annonce. Veuillez réessayer."
          );
        });
    });
  }

  // Drag and drop pour les fichiers
  const fileUpload = document.getElementById("fileUpload");

  if (fileUpload) {
    fileUpload.addEventListener("dragover", (e) => {
      e.preventDefault();
      fileUpload.style.borderColor = "#4CAF50";
      fileUpload.style.backgroundColor = "#f0fff0";
    });

    fileUpload.addEventListener("dragleave", () => {
      fileUpload.style.borderColor = "#e0e0e0";
      fileUpload.style.backgroundColor = "#fafafa";
    });

    fileUpload.addEventListener("drop", (e) => {
      e.preventDefault();
      fileUpload.style.borderColor = "#e0e0e0";
      fileUpload.style.backgroundColor = "#fafafa";

      document.getElementById("photos").files = e.dataTransfer.files;
      const event = new Event("change");
      document.getElementById("photos").dispatchEvent(event);
    });
  }
});
