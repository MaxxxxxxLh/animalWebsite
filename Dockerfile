FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

# Active mod_rewrite si besoin :
RUN a2enmod rewrite
