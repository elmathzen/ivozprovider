#!/bin/bash
set -e

# Fonction pour afficher les messages d'information
info() {
    echo -e "\e[1;34m[INFO]\e[0m $1"
}

# Fonction pour afficher les messages d'erreur
error() {
    echo -e "\e[1;31m[ERREUR]\e[0m $1"
    exit 1
}

# Vérifier que l'utilisateur est root
if [ "$(id -u)" -ne 0 ]; then
    error "Ce script doit être exécuté en tant que root (sudo ./build-native-debian12.sh)"
fi

# Créer un répertoire pour les paquets générés
mkdir -p ./debian-packages

# Vérifier que le système est Debian 12
if ! grep -q "bookworm" /etc/os-release; then
    error "Ce script est conçu pour Debian 12 (Bookworm). Votre système ne semble pas être Debian 12."
fi

# Installer les dépendances de construction
info "Installation des dépendances de construction..."
apt-get update || error "Impossible de mettre à jour les dépôts"

# Installer les dépendances de base pour la construction de paquets
apt-get install -y \
    build-essential \
    debhelper \
    dh-exec \
    devscripts \
    fakeroot \
    lintian \
    git \
    curl \
    wget \
    gnupg \
    apt-transport-https \
    ca-certificates || error "Impossible d'installer les dépendances de base"

# Ajouter le dépôt Irontec si nécessaire
if [ ! -f "/etc/apt/sources.list.d/irontec.list" ]; then
    info "Ajout du dépôt Irontec..."
    echo "deb http://packages.irontec.com/debian bookworm main extra" > /etc/apt/sources.list.d/irontec.list
    wget -qO - http://packages.irontec.com/public.key | apt-key add - || error "Impossible d'ajouter la clé du dépôt Irontec"
    apt-get update || error "Impossible de mettre à jour les dépôts après l'ajout du dépôt Irontec"
fi

# Installer les dépendances de construction spécifiques à ivozprovider
info "Installation des dépendances spécifiques à ivozprovider..."
apt-get install -y \
    composer \
    gettext \
    libjs-jquery \
    libjs-sphinxdoc \
    make \
    openssh-client \
    php8.2 \
    php8.2-cli \
    php8.2-common \
    php8.2-mailparse \
    php8.2-mbstring \
    php8.2-opcache \
    php8.2-readline \
    php8.2-xml \
    php8.2-zip \
    python3 \
    python3-alabaster \
    python3-sphinx \
    python3-sphinx-rtd-theme \
    ruby-dev \
    sphinx-common \
    nodejs \
    npm \
    golang || error "Impossible d'installer les dépendances spécifiques"

# Installer yarn via le dépôt officiel
info "Installation de yarn via le dépôt officiel..."
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
apt-get update && apt-get install -y yarn || error "Impossible d'installer yarn"

# Vérifier que yarn est correctement installé
if ! command -v yarn &> /dev/null; then
    error "Yarn n'a pas été installé correctement"
fi
yarn --version || error "Impossible d'exécuter yarn"

# Construire le paquet
info "Construction du paquet ivozprovider..."
cd "$(dirname "$0")" || error "Impossible de changer de répertoire"

# Définir les variables d'environnement nécessaires
export APP_ENV=prod
export TEMP=/tmp

# Construire le paquet avec l'option -d pour ignorer les dépendances manquantes si nécessaire
info "Exécution de dpkg-buildpackage..."
dpkg-buildpackage -us -uc -b || {
    info "Tentative avec l'option -d pour ignorer les dépendances manquantes..."
    dpkg-buildpackage -us -uc -b -d || error "La construction du paquet a échoué"
}

# Déplacer les paquets générés
info "Déplacement des paquets générés..."
mv ../*.deb ./debian-packages/ 2>/dev/null || info "Aucun paquet .deb généré dans le répertoire parent"

# Afficher les paquets générés
info "Paquets générés :"
ls -la ./debian-packages/

info "Construction terminée avec succès ! Les paquets se trouvent dans le répertoire ./debian-packages"