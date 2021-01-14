# E2_MF0493_3

# Instalaciones.sh

Para la instalación se hará uso de la instrucción:

***********************************
sudo bash instalaciones.sh
***********************************

Nota: Estar atentos sobre las interacciones que solicite el script. Recomiendo usar una sola clave durante todo el proceso y cambiarlas al terminar para evitar confusiones.

En caso de intentar correr el script sin privilegios sudo saldrá un aviso.

Al finalizar las instalaciones el propio Script mostrará por pantalla una serie de confirmaciones con las versiones de los servicios instalados.

Los servicios Nginx y Apache  vienen por defecto configurados para correr en el puerto 80 de manera que habrá que alternar su uso, mientras no se cambie la configuración, haciendo uso de los siguientes comandos:

sudo systemctl stop apache2 // Detiene apache

sudo systemctl start apache2 // Inicia apache

sudo systemctl stop nginx // Detiene nginx

sudo systemctl start nginx // Inicia nginx