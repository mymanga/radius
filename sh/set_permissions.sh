#!/bin/bash

chown -R www-data:www-data /var/www
chown -R www-data:www-data /var/www/html
chmod -R 777 /var/www/html/storage 
chmod -R 777 /var/www/html/bootstrap/cache 
chown -R www-data:www-data /var/www/html/bootstrap/cache
