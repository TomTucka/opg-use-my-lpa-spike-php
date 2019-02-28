FROM nginx:stable-alpine

WORKDIR /var/www

COPY default.conf /etc/nginx/conf.d/default.conf
COPY mime.types /etc/nginx/mime.types
COPY /assets web/assets
COPY /javascript web/javascript
COPY /stylesheets web/stylesheets
COPY index.html web/index.html
