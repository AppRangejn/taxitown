FROM php:8.2-fpm

# Встановлюємо системні залежності та розширення PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libonig-dev \
    npm \
    && docker-php-ext-install pdo pdo_pgsql mbstring

# Встановлюємо Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Встановлюємо Node.js та Yarn для Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn
