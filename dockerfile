FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libonig-dev \
    zlib1g-dev \
    libzip-dev\
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get composer
COPY --from=composer:lts /usr/bin/composer /usr/local/bin/composer

# Install php extension
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
docker-php-ext-install gd && \
docker-php-ext-install mysqli && \
docker-php-ext-install pdo_mysql && \
docker-php-ext-install exif && \
docker-php-ext-install zip

# Copy app files
WORKDIR /var/www/html
COPY src /var/www/html

# Adjust the permissions
RUN chown -R www-data:www-data /var/www

USER www-data

# Install app dependencies
RUN composer install --no-dev

# Laravel optimization commands
RUN php artisan view:cache

EXPOSE 8000

CMD ["bash", "./docker-entrypoint.sh"]