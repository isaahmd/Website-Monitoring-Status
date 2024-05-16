FROM php:8.0-apache
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli
RUN apt-get update
RUN apt-get install -y iputils-ping