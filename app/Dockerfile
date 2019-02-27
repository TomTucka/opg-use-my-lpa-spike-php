FROM composer AS composer
COPY . /app

RUN composer install

FROM php:7-fpm-alpine

WORKDIR /var/www

COPY ./ /app
COPY --from=composer /app/vendor vendor
