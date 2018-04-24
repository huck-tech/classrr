## Airdojo Study Platform

### Config LEMP
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-16-04

### Packages (globally)
```
sudo apt-get install -y build-essential

cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

curl -sL https://deb.nodesource.com/setup_7.x | sudo -E bash -
sudo apt-get install -y nodejs

sudo apt-get install php-mbstring php7.0-mbstring php-gettext php-curl php-zip php-mysql php7.0-gd
```

### Directory permissions
Set permissions to system directories from app_base_path
```
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

```

### Assets
To create symbolic link, use this command
```
php artisan storage:link
```
### Elasticsearch

get Elasticsearch to run on 16.04 you have to set START_DAEMON to true on /etc/default/elasticsearch
### DB
To get all table columns
```
DB::getSchemaBuilder()->getColumnListing('table');
```
CREATE DATABASE airdojo_dev CHARACTER SET utf8 COLLATE utf8_unicode_ci;

### Twilio
Here is GEO settings
https://www.twilio.com/console/sms/settings/geo-permissions

### Update
Deployer https://deployer.org/docs/installation

### Debug
Docs https://github.com/barryvdh/laravel-debugbar

### Create default Index
php artisan tinker
>>> $c = Sleimanx2\Plastic\Facades\Plastic::getClient();
>>> $c->indices()->create(['index' => Plastic::getDefaultIndex()]);