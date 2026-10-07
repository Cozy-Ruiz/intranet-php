FROM php:8.1-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libzip-dev zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-interaction --prefer-dist --no-progress --no-scripts --no-plugins

COPY src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R a+rX /var/www/html

EXPOSE 80


