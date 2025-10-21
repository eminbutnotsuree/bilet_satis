FROM php:8.1-apache
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_sqlite
RUN a2enmod rewrite