FROM php:8.2-fpm-alpine AS builder

WORKDIR /var/www

RUN apk add --no-cache \
    icu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nginx \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_mysql intl zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


COPY package.json package-lock.json ./
RUN npm install

COPY composer.json composer.lock ./
RUN composer install --no-scripts --optimize-autoloader

COPY . .

RUN npm run build
RUN rm -rf node_modules

# final build small image
FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx icu-dev libzip-dev redis supervisor cronie

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo pdo_mysql intl zip pcntl \
    && apk del .build-deps

WORKDIR /var/www/pollux

COPY --from=builder /var/www/ .

RUN chown -R www-data:www-data /var/www/pollux

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/supervisors/*.conf /etc/supervisor/

RUN sed '$a\' docker/cron >> /etc/crontabs/root

EXPOSE 80 8080

CMD ["/bin/sh", "-c", "redis-server --daemonize yes && supervisord -c /etc/supervisord.conf"]

# CMD ["/bin/sh", "-c", "redis-server --daemonize yes && php-fpm -D && nginx -g 'daemon off;'"]
