FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip intl xml gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

RUN php artisan config:cache && php artisan route:cache

RUN php artisan config:clear
RUN php artisan cache:clear

CMD ["sh", "-c", "php artisan migrate --force --graceful && php artisan serve --host=0.0.0.0 --port=8080"]