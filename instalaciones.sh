#!/bin/bash

if [ "$(whoami)" != "root" ]; then
    echo "Run script as ROOT please. (sudo !!)"
    exit
fi

## Instalamos apache
apt-get install apache2 -y

## Instalamos PHP
apt-get install php php-mysql libapache2-mod-php -y

## Instalar MariaDB
apt-get install mariadb-server mariadb-client -y

## Securizamos la instalación de MariDB
mysql_secure_installation

## Instalamos phpmyadmin
apt-get install phpmyadmin -y

## Cambiamos el propietario del directorio /html que es en donde irán nuestras páginas, se agrega el usuario pi al grupo
## y se cambian los permisos de lectura y escritura
chown -R www-data:www-data /var/www/html
usermod -g www-data pi
chmod -R 777 /var/www

echo
echo
echo

## El siguiente comando reinicia apache2 para que corra phpmyadmin
service apache2 reload

## Vamos ahora a instalar Nginx
apt-get install nginx -y
## Atención: El servicio se intentará iniciar en el puerto 80 y no podrá hacerlo por que
## ahí estará corriendo el servicio de Apache.

## Finalmente vamos a instalar Vsftp
apt-get install vsftpd -y
## Ya podremos usar el servidor ftp con las credenciales de los usuarios del sistema

##################
## Ahora vamos a realizar las comprobaciones de la instalación realizada
################



##Limpia la pantalla
clear

## Vemos la versión de apache 
echo "La versión de apache es: "
apache2 -v

## Versión de Nginx
echo
echo "La versión de Nginx es: "
nginx -v

## Versión de PHP
echo
echo "Versión de PHP es: "
php -v

## Version de Vsftp
echo
echo "Versión de Vsftp es: "
vsftpd -v

## Para la comprobación de mariadb será necesario loguearse en el cli del SGBD con las
## credenciales creadas

echo "Instalación finalizada!!!!"
