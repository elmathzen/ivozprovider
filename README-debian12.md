# Guide de construction et déploiement d'ivozprovider pour Debian 12

Ce guide explique comment construire et déployer le paquet ivozprovider pour Debian 12 (Bookworm).

## Méthodes de construction

Vous avez deux options pour construire les paquets ivozprovider pour Debian 12 :

### Option 1 : Construction avec Docker

Cette méthode utilise Docker pour créer un environnement de construction isolé.

#### Prérequis
- Docker installé sur votre système

#### Étapes
1. Exécutez le script de construction :
   ```bash
   ./build-debian12.sh
   ```

   Ce script va :
   - Créer un répertoire `./debian-packages` pour stocker les paquets générés
   - Construire une image Docker basée sur Debian 12 avec toutes les dépendances nécessaires
   - Exécuter le processus de construction du paquet dans un conteneur
   - Copier les paquets générés dans le répertoire `./debian-packages`

### Option 2 : Construction native

Cette méthode construit directement les paquets sur votre système Debian 12 sans utiliser Docker.

#### Prérequis
- Système Debian 12
- Accès root

#### Étapes
1. Exécutez le script de construction native en tant que root :
   ```bash
   sudo ./build-native-debian12.sh
   ```

   Ce script va :
   - Installer toutes les dépendances nécessaires pour la construction
   - Construire les paquets directement sur votre système
   - Placer les paquets générés dans le répertoire `./debian-packages`

## Déploiement du paquet

Pour déployer le paquet ivozprovider sur un système Debian 12, suivez ces étapes :

1. Assurez-vous que les paquets ont été générés avec succès (le répertoire `./debian-packages` contient des fichiers .deb).

2. Exécutez le script de déploiement en tant que root :
   ```bash
   sudo ./deploy-debian12.sh
   ```

   Ce script va :
   - Vérifier que votre système est bien Debian 12
   - Ajouter le dépôt Irontec si nécessaire
   - Installer les paquets générés
   - Résoudre automatiquement les dépendances manquantes
   - Vérifier que l'installation a réussi

3. Une fois l'installation terminée, les services ivozprovider seront disponibles sur votre système.

## Dépendances

Le paquet ivozprovider dépend de nombreux paquets, notamment :

- PHP 8.2 et ses extensions
- MariaDB/MySQL
- Kamailio
- Asterisk
- Redis
- et bien d'autres...

Le script de déploiement s'occupera automatiquement de l'installation de ces dépendances.

## Résolution des problèmes

### Problèmes de construction

#### Avec Docker
- Vérifiez que Docker est correctement installé et fonctionne
- Assurez-vous que vous avez suffisamment d'espace disque
- Consultez les logs de construction pour identifier les erreurs

#### Construction native
- Vérifiez que vous êtes bien sur Debian 12
- Assurez-vous que vous avez un accès Internet pour télécharger les dépendances
- Vérifiez que vous avez suffisamment d'espace disque
- Consultez les logs d'erreur pour plus de détails

### Problèmes de déploiement
- Vérifiez que votre système est bien Debian 12
- Assurez-vous que vous avez un accès Internet pour télécharger les dépendances
- Consultez les logs système (`/var/log/syslog`) pour plus d'informations

## Configuration post-installation

Après l'installation, vous devrez configurer ivozprovider selon vos besoins. Consultez la documentation officielle pour plus d'informations sur la configuration.

## Paquets générés

Les paquets suivants seront générés :

- `ivozprovider` : Paquet virtuel qui dépend de tous les autres paquets
- `ivozprovider-profile-as` : Profil pour les serveurs d'application
- `ivozprovider-profile-data` : Profil pour les systèmes de données
- `ivozprovider-profile-portal` : Profil pour le portail
- `ivozprovider-profile-proxy` : Profil pour les systèmes proxy
- Et d'autres paquets spécifiques à des composants particuliers

Vous pouvez installer uniquement les paquets dont vous avez besoin, ou installer le paquet `ivozprovider` complet qui installera tous les composants.