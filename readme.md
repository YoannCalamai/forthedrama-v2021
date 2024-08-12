# For The Drama

Une application web pour faire jouer des jeux hérités de Pour la Reine. Ce code est utilisé en production pour le site forthedrama.com
  

## Minimum requis

* php v7.4

* mysql ou mariadb

* apache2 ou nginx


## Installation

### Installation manuelle

* Installer les dépendances via la commande

```

apt-get update && apt-get install -y build-essential libonig-dev zlib1g-dev libzip-dev libpng-dev libjpeg62-turbo-dev libwebp-dev libfreetype6-dev locales zip jpegoptim optipng pngquant gifsicle vim unzip

```

* Installer composer lts https://getcomposer.org/download/

* Installer les extensions php gd, mysql et zip

```

apt-get install php5-gd php5-mysql php5-zip

```
* Copier les sources de l'application dans /var/www/html
* Ajuster les permissions pour l'utilisateur www-data
```
chown  -R  www-data:www-data  /var/www
```
  * Générer une clef unique pour l’application
```
php artisan key:generate --show
```
* Dupliquer le fichier .env.forthedrama et nommer la copie .env
* Changer les valeurs suivantes dans le fichier :
	* APP_KEY => la clé unique générée précédemment
	* DB_HOST => le nom ou l'adresse de votre serveur mysql/mariadb
	* DB_USERNAME => le nom d'utilisateur pour se connecter au serveur
    * DB_PASSWORD => le mot de passe correspondant
	* DB_DATABASE => le nom de votre base de données
	* MAIL_HOST => le nom ou l'adresse de votre serveur SMTP
	* MAIL_USERNAME => le nom d'utilisateur pour se connecter au serveur 
	* MAIL_PASSWORD => le mot de passe correspondant
	* MAIL_FROM => l'adresse qui apparaitra comme expéditeur
 * Installer les dépendances de l'application
```
composer  install  --no-dev
```
* Créer le schéma de la base de données
```
php  artisan  migrate:refresh  --seed  --force
```
*  Démarrer l'application
```
php  artisan  serve
```

### Installation docker

* Créer un répertoire
* Dans celui-ci, créer un fichier docker-compose.yml contenant
```
services:
	app:
	  image: yoanncalamai/forthedrama
	  ports:
	    - 8000:8000
	  env_file:
	    - .env
	  depends_on:
	    database:
	      condition: service_healthy
	      restart: true

  database:
    image: mariadb:lts
    environment:
      - MARIADB_DATABASE=${DB_DATABASE}
      - MARIADB_USER=${DB_USERNAME}
      - MARIADB_PASSWORD=${DB_PASSWORD}
      - MARIADB_ROOT_PASSWORD=${DB_PASSWORD}
    volumes:
      - forthedrama_data:/var/lib/mysql
    healthcheck:
      test: ["CMD", "healthcheck.sh", "--connect", "--innodb_initialized"]
      start_period: 10s
      interval: 10s
      timeout: 5s
      retries: 3
 

volumes:
  forthedrama_data:
```

* Créer un fichier .env contenant au minimum les variables suivantes
```
APP_NAME="For the drama test"
APP_ENV=production
APP_KEY=base64:mZERyHIWDalmVyDeU+Z6tC/Oa7SOXloa74TheDRAMA=
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=forthedramadb
DB_USERNAME=ftduser
DB_PASSWORD=ftdPassw0rd
DB_CREATESCHEMA=true

MAIL_DRIVER=smtp
MAIL_HOST=mysmtpserver
MAIL_PORT=587
MAIL_USERNAME=myMailUser
MAIL_PASSWORD=mailPass0rd
MAIL_ENCRYPTION=TLS
MAIL_FROM=noreply@exemple.fr
```
* Démarrer l'application
```
docker compose up -d
```

## Liste des variables d'environnement

|Variable|Description|Obligatoire|Valeur par défaut|
|--|--|--|--|
|APP_NAME|Nom de l'application|Non|For the drama fork|
|APP_ENV||Non|production|
|APP_KEY||Oui|-|
|APP_URL||Non|http://localhost:8000|
|APP_DEBUG||Non|false|
|DEBUGBAR_ENABLED||Non|false|
|DB_CONNECTION||Oui|mysql|
|DB_HOST||Oui|localhost|
|DB_PORT||Oui|3306|
|DB_DATABASE||Oui|forge|
|DB_USERNAME||Oui|forge|
|DB_PASSWORD||Oui|-|
|DB_CREATESCHEMA||Non|false|
|LOG_CHANNEL||Non|stack|
|BROADCAST_DRIVER||Non|log|
|CACHE_DRIVER||Non|file|
|QUEUE_CONNECTION||Non|sync|
|SESSION_DRIVER||Non|file|
|SESSION_LIFETIME||Non|480|
|REDIS_HOST||Non|127.0.0.1|
|REDIS_PASSWORD||Non|-|
|REDIS_PORT||Non|6379|
|MAIL_DRIVER||Non|smtp|
|MAIL_ENCRYPTION||Non|TLS|
|MAIL_HOST||Oui|smtp.mailgun.org|
|MAIL_PORT||Non|587|
|MAIL_USERNAME||Oui|-|
|MAIL_PASSWORD||Oui|-|
|MAIL_FROM||Non|hello@exemple.com|


