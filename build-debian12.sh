#!/bin/bash
set -e

# Créer un répertoire temporaire pour les paquets générés
mkdir -p ./debian-packages

# Construire l'image Docker pour la construction du paquet
docker build -t ivozprovider-builder -f Dockerfile.debian12 .

# Exécuter le conteneur pour construire le paquet
docker run --rm -v $(pwd)/debian-packages:/output ivozprovider-builder

echo "Les paquets Debian ont été générés dans le répertoire ./debian-packages"