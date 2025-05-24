#!/bin/bash
# Vérifier si le dossier vendor n'existe pas ou s'il est vide
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor)" ]; then
  echo "Le dossier vendor est vide ou absent, exécution de 'composer install'..."
  composer install && composer require firebase/php-jwt
else
  echo "Les dépendances sont déjà installées."
fi

# Générer une clé secrète JWT si elle n'existe pas déjà
JWT_KEY_FILE="./jwt.key"
if [ ! -f "$JWT_KEY_FILE" ]; then
  echo "Génération d'une nouvelle clé JWT..."
  openssl rand -hex 32 > "$JWT_KEY_FILE"
  echo "✅ Clé JWT générée dans $JWT_KEY_FILE"
else
  echo "✅ Clé JWT déjà présente dans $JWT_KEY_FILE"
fi

# Lancer le commandement principal (ici apache)
exec "$@"
