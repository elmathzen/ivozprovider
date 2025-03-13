#!/bin/bash
set -e

# Vérifier que les paquets ont été générés
if [ ! -d "./debian-packages" ] || [ -z "$(ls -A ./debian-packages)" ]; then
    echo "Aucun paquet trouvé dans le répertoire ./debian-packages"
    echo "Veuillez d'abord exécuter ./build-debian12.sh pour générer les paquets"
    exit 1
fi

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
    error "Ce script doit être exécuté en tant que root (sudo ./deploy-debian12.sh)"
fi

# Vérifier que le système est Debian 12
if ! grep -q "bookworm" /etc/os-release; then
    error "Ce script est conçu pour Debian 12 (Bookworm). Votre système ne semble pas être Debian 12."
fi

# Mettre à jour les dépôts
info "Mise à jour des dépôts..."
apt-get update || error "Impossible de mettre à jour les dépôts"

# Ajouter le dépôt Irontec si nécessaire
if [ ! -f "/etc/apt/sources.list.d/irontec.list" ]; then
    info "Ajout du dépôt Irontec..."
    echo "deb http://packages.irontec.com/debian bookworm main extra" > /etc/apt/sources.list.d/irontec.list
    wget -qO - http://packages.irontec.com/public.key | apt-key add - || error "Impossible d'ajouter la clé du dépôt Irontec"
    apt-get update || error "Impossible de mettre à jour les dépôts après l'ajout du dépôt Irontec"
fi

# Installer les paquets générés
info "Installation des paquets ivozprovider..."
dpkg -i ./debian-packages/*.deb || {
    info "Résolution des dépendances manquantes..."
    apt-get -f install -y || error "Impossible de résoudre les dépendances"
    
    # Réessayer l'installation
    info "Réinstallation des paquets ivozprovider..."
    dpkg -i ./debian-packages/*.deb || error "Impossible d'installer les paquets"
}

# Vérifier que l'installation a réussi
if dpkg -l | grep -q ivozprovider; then
    info "Installation réussie ! Le paquet ivozprovider est maintenant installé."
    
    # Afficher la version installée
    VERSION=$(dpkg -l | grep ivozprovider | head -n 1 | awk '{print $3}')
    info "Version installée : $VERSION"
    
    # Afficher les services disponibles
    info "Services disponibles :"
    systemctl list-unit-files | grep ivozprovider
else
    error "L'installation semble avoir échoué. Le paquet ivozprovider n'est pas installé."
fi

info "Déploiement terminé avec succès !"