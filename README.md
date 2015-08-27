# MAGESKO

## Prérequis

- PHP 5.5
- MYSQL 5
- MEMCACHED
- OPCACHE

## Installation

- Installer composer
- Installer bower (nécessite node)
    - Sur Ubuntu si node a été installé avec apt-get, créer un lien symbolique entre nodejs et node

- Installer les dépendances :

```bash
$ composer install
$ bower install
```
Si problème avec l'installation des dépendances de composer executer la commande suivante :
```bash
$ php composer.phar global require "fxp/composer-asset-plugin:1.0.0"
```

- Initialiser le projet :

```bash
$ yii/init
```

- Créer la base de données "kalibao" avec l'encodage "utf8_general_ci" à partir du fichier SQL "kalibao/common/db/db.sql"
- Créer un lien symbolique entre le dossier "kalibao/data" et "kalibao/static/common/data"
```bash
$ cd kalibao/static/common
$ ln -s ../../data
```
- Déclarer le domaine static.kalibaoframework.lan et faire pointer son virtual host vers le dossier "kalibao/static"
- Rendre les dossiers "kalibao/data/*" accessiblent en lecture et écriture
- Rendre le dossier "kalibao/tmp" accessible en lecture et écriture
- Configurer le fichier "kalibao/common/config/main-local.php"

## Installation de l'application backend

- Créer un lien symbolique entre le dossier "kalibao/backend/web/assets" et "kalibao/static/backend/assets"
```bash
$ cd kalibao/static/backend
$ ln -s ../../backend/web/assets
```
- Créer un lien symbolique entre le dossier "kalibao/backend/web/assets-compressed" et "kalibao/static/backend/assets-compressed"
```bash
$ cd kalibao/static/backend
$ ln -s ../../backend/web/assets-compressed
```
- Déclarer le domaine backend.kalibaoframework.lan et faire pointer son virtual host le dossier kalibao/backend/web
- Configurer le fichier "kalibao/backend/config/main-local.php"
- Accès à l'application backend :
    Username : admin@kalibao.com
    Password : password

## Installation de l'application frontend

- Créer un lien symbolique entre le dossier "kalibao/frontend/web/assets" et "kalibao/static/frontend/assets"
```bash
$ cd kalibao/static/frontend
$ ln -s ../../frontend/web/assets
```

- Créer un lien symbolique entre le dossier "kalibao/frontend/web/assets-compressed" et "kalibao/static/frontend/assets-compressed"
```bash
$ cd kalibao/static/frontend
$ ln -s ../../frontend/web/assets-compressed
```
- Déclarer le domaine frontend.kalibaoframework.lan et faire pointer son virtual host vers le dossier "kalibao/frontend/web"
- Configurer le fichier "kalibao/frontend/config/main-local.php"

## FIN

## Compression des assets avant mise en production

Backend : 

- Configurer les dépendances dans le "kalibao/backend/config/assets-prod.php"
- Générer les assets
- Compresser les assets :

```bash
$ yii/yii assetscompressor/compress kalibao/backend/config/assets.php
```

Frontend : 

- Configurer les dépendances dans le fichier "kalibao/frontend/config/assets-prod.php"
- Générer les assets
- Compresser les assets :

```bash
$ yii/yii assetscompressor/compress kalibao/frontend/config/assets.php
```
