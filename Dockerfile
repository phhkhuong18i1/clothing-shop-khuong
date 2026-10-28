# syntax=docker/dockerfile:1.7

FROM php:8.3-fpm-alpine AS php-base
ARG BUILD_JOBS=2

RUN apk add --no-cache curl freetype icu-libs libjpeg-turbo libpng libxml2 libzip oniguruma \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS curl-dev freetype-dev icu-dev libjpeg-turbo-dev libpng-dev libxml2-dev libzip-dev oniguruma-dev
RUN docker-php-ext-install -j"${BUILD_JOBS}" dom
RUN docker-php-ext-install -j"${BUILD_JOBS}" pdo_mysql simplexml xml xmlwriter
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"${BUILD_JOBS}" gd
RUN docker-php-ext-install -j"${BUILD_JOBS}" curl fileinfo mbstring opcache zip
RUN apk del .build-deps

COPY docker/php/app.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
WORKDIR /var/www/html
HEALTHCHECK --interval=20s --timeout=3s --start-period=20s --retries=3 \
    CMD php -r '$socket = @fsockopen("127.0.0.1", 9000); exit($socket ? 0 : 1);'

FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

FROM php-base AS dependencies
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www/html
COPY . .
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev --prefer-dist --no-interaction --no-progress --no-scripts \
    --optimize-autoloader --classmap-authoritative

FROM dependencies AS development
RUN printf '%s\n' 'opcache.validate_timestamps=1' 'opcache.revalidate_freq=0' \
    > /usr/local/etc/php/conf.d/zz-development-opcache.ini
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --prefer-dist --no-interaction --no-progress --no-scripts \
    && composer dump-autoload --optimize --no-scripts
COPY docker/app-entrypoint.sh /usr/local/bin/app-entrypoint
RUN chmod 0755 /usr/local/bin/app-entrypoint \
    && mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache
ENTRYPOINT ["app-entrypoint"]
CMD ["php-fpm", "-F"]

FROM php-base AS production
ENV APP_ENV=production APP_DEBUG=false
WORKDIR /var/www/html
COPY --from=dependencies --chown=www-data:www-data /var/www/html /var/www/html
COPY --from=assets --chown=www-data:www-data /app/public/build /var/www/html/public/build
COPY docker/app-entrypoint.sh /usr/local/bin/app-entrypoint
RUN chmod 0755 /usr/local/bin/app-entrypoint \
    && mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && ln -sfn ../storage/app/public public/storage \
    && chown -R www-data:www-data storage bootstrap/cache \
    && php artisan package:discover --ansi
ENTRYPOINT ["app-entrypoint"]
CMD ["php-fpm", "-F"]
FROM nginx:stable-alpine3.24-slim AS nginx
COPY --from=production /var/www/html/public /var/www/html/public
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /var/www/html/storage/app/public
EXPOSE 80
