FROM php:8.2-fpm

ARG user
ARG uid
ARG laravel_version='^11.0'
ARG directory='/var/www'

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create project Laravel
# RUN cd ${directory} && composer create-project laravel/laravel:${laravel_version}

# Set working directory
WORKDIR ${directory}

# Create system user to run Composer and Artisan Commands
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user