FROM php:8.1.11-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-install pgsql pdo_pgsql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

ENV XDEBUG_CONFIG="mode=debug,develop client_host=172.17.0.1 client_port=9003"
ENV PHP_IDE_CONFIG="serverName=Dev"
ENV XDEBUG_SESSION=1

RUN echo "xdebug.mode=debug,develop" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=172.17.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -o composer https://getcomposer.org/download/2.3.5/composer.phar && chmod a+x composer && mv composer /usr/local/bin/composer