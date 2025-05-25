#!/bin/bash
# Vérifier si le dossier vendor n'existe pas ou s'il est vide
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor)" ]; then
  echo "📦 Le dossier 'vendor' est vide ou absent, installation des dépendances..."
  composer install
else
  echo "✅ Les dépendances sont déjà installées."
fi

# Vérifier si les paquets firebase/php-jwt et phpmailer/phpmailer sont installés
MISSING_PACKAGES=()

if [ ! -d "vendor/firebase/php-jwt" ]; then
  MISSING_PACKAGES+=("firebase/php-jwt")
fi

if [ ! -d "vendor/phpmailer/phpmailer" ]; then
  MISSING_PACKAGES+=("phpmailer/phpmailer")
fi

if [ ${#MISSING_PACKAGES[@]} -gt 0 ]; then
  echo "📦 Installation des paquets manquants : ${MISSING_PACKAGES[*]}"
  composer require "${MISSING_PACKAGES[@]}"
else
  echo "✅ Tous les paquets nécessaires sont déjà installés."
fi

# Générer une clé secrète JWT si elle n'existe pas déjà
JWT_KEY_FILE="./app/Utils/jwt.key"
if [ ! -f "$JWT_KEY_FILE" ]; then
  echo "Génération d'une nouvelle clé JWT..."
  openssl rand -hex 32 > "$JWT_KEY_FILE"
  echo "✅ Clé JWT générée dans $JWT_KEY_FILE"
else
  echo "✅ Clé JWT déjà présente dans $JWT_KEY_FILE"
fi

# Lancer le commandement principal (ici apache)
exec "$@"
