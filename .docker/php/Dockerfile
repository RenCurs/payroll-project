FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-install pgsql pdo_pgsql \
    && pecl install xdebug \

RUN curl -o composer https://getcomposer.org/download/2.3.5/composer.phar && chmod a+x composer && mv composer /usr/local/bin/composer