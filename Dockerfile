FROM dunglas/frankenphp:1-php8.4-bookworm
RUN install-php-extensions intl mbstring pdo_sqlite opcache zip \
    && apt-get update && apt-get install -y --no-install-recommends unzip git \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
WORKDIR /app
COPY . /app
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts \
    && mkdir -p db storage logs tmp/cache/models tmp/cache/persistent tmp/cache/views tmp/sessions \
    && chown -R www-data:www-data /app /config /data
COPY docker/app_local.php /app/config/app_local.php
COPY docker/Caddyfile /etc/caddy/Caddyfile
COPY docker/production.ini /usr/local/etc/php/conf.d/zz-production.ini
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
USER www-data
EXPOSE 8080
ENTRYPOINT ["/bin/sh", "/app/docker/entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile", "--adapter", "caddyfile"]
