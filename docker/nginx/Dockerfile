FROM node:13 AS node
LABEL maintainer "Patrick Baber <patrick.baber@ueber.io>"

WORKDIR /var/www

COPY ./src/resources /var/www/src/resources
COPY ./webpack /var/www/webpack
COPY ./.editorconfig /var/www/.editorconfig
COPY ./.eslintrc.js /var/www/.eslintrc.js
COPY ./package.json /var/www/package.json
COPY ./yarn.lock /var/www/yarn.lock

RUN yarn install && \
    yarn build && \
    rm -Rf node_modules

FROM nginx:1.17-alpine
LABEL maintainer "Patrick Baber <patrick.baber@ueber.io>"

COPY docker/nginx/etc/default.conf /etc/nginx/conf.d/default.conf
COPY src/public/ /var/www/public
COPY --from=node /var/www/src/public /var/www/public

WORKDIR /var/www/
