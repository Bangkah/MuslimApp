FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    libzip-dev libonig-dev libxml2-dev \
    sqlite3 libsqlite3-dev pkg-config \
    && docker-php-ext-configure pdo_sqlite --with-pdo-sqlite \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip

WORKDIR /var/www

COPY . .

# Install composer (fix untuk Podman)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN composer install --optimize-autoloader

RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

CMD ["php-fpm"]
