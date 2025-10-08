# PHP ve Apache sunucusu içeren resmi bir imaj kullanıyoruz
FROM php:8.1-apache

# Gerekli sistem paketlerini kuruyoruz ve temizlik yapıyoruz (en iyi pratik)
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Şimdi PHP'mizin versiyonuna uygun SQLite eklentisini 'pişiriyoruz'
RUN docker-php-ext-install pdo_sqlite

# Apache'in projemizin klasörünü sunmasına izin veriyoruz
RUN a2enmod rewrite