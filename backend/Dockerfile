FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    zip \
    unzip \
    git \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    postgresql-dev

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    intl \
    mbstring \
    zip \
    opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

RUN mkdir -p /var/www/html/var && chown -R www-data:www-data /var/www/html/var

COPY docker/nginx.conf /etc/nginx/nginx.conf

COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
