FROM nginx:1.17-alpine
LABEL maintainer "Patrick Baber <patrick.baber@servivum.com>"

COPY docker/nginx/etc/default.conf /etc/nginx/conf.d/default.conf
COPY src/public/ /var/www/public

WORKDIR /var/www/
