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


FROM php:7.4-fpm-buster
LABEL maintainer "Patrick Baber <patrick.baber@ueber.io>"

# Install PHP dependencies
RUN buildDeps=" \
        libgmp-dev \
        libicu-dev \
    " \
    runtimeDeps=" \
        libgmp10 \
    " && \
    apt-get update && \
    apt-get install -y --no-install-recommends $buildDeps $runtimeDeps && \
    docker-php-ext-install \
    gmp \
	pdo_mysql \
    && \
    apt-get purge -y $buildDeps && \
    rm -r /var/lib/apt/lists/*

# Install pandoc
RUN apt-get update && \
    apt-get install -y wget && \
    mkdir -p /usr/src/pandoc && \
    cd /usr/src/pandoc && \
    wget https://github.com/jgm/pandoc/releases/download/2.9.2/pandoc-2.9.2-1-amd64.deb && \
    dpkg -i pandoc-2.9.2-1-amd64.deb && \
    apt-get purge -y wget && \
    rm -rf /usr/src/pandoc && \
    rm -r /var/lib/apt/lists/*

# Install Redis PECL extension
RUN pecl install redis && \
    docker-php-ext-enable redis

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Override with custom settings
COPY docker/php/etc/custom.ini $PHP_INI_DIR/conf.d/

# Add entrypoint script
COPY docker/php/usr/local/bin/docker-entrypoint.sh /usr/local/bin
RUN curl -o /usr/local/bin/wait-for https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh && \
    chmod +x /usr/local/bin/wait-for
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]

# Add Healthcheck
RUN apt-get update && \
    apt-get install -y --no-install-recommends procps && \
    rm -r /var/lib/apt/lists/*
HEALTHCHECK --interval=30s --start-period=120s --timeout=5s --retries=3 \
    CMD ps aux | egrep '[s]chedule' || ps aux | egrep '[q]ueue' || ps aux | egrep '[f]pm'

# Install Composer
ENV PATH="/composer/vendor/bin:$PATH"
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_HOME /composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip \
    && rm -r /var/lib/apt/lists/*

# Install app dependencies
COPY --chown=www-data:www-data src/composer.* /var/www/
RUN cd /var/www/ && \
    composer install --no-autoloader --no-scripts && \
    chown -R www-data:www-data /var/www/

# Add application & generate classmap
COPY --chown=www-data:www-data src/ /var/www/
COPY --from=node /var/www/src/public /var/www/public

RUN cd /var/www/ && \
    composer dump-autoload --no-scripts && \
    chown -R www-data:www-data /var/www/

VOLUME /var/www/storage/
WORKDIR /var/www/
