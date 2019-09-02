FROM php:7.2-apache as builder

RUN a2enmod rewrite

LABEL maintainer="akib"

ARG DB_HOST
ARG DB_USER
ARG DB_PASSWORD
ARG DB_NAME

ENV DB_HOST=${DB_HOST}
ENV DB_USER=${DB_USER}
ENV DB_PASSWORD=${DB_PASSWORD}
ENV DB_NAME=${DB_NAME}

# Working dir
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) iconv \
    pdo \
    pdo_pgsql \
    pgsql \
    zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# Copy the dependency registry
COPY composer*.json .

# Copy the composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install and autoload
RUN composer install \
    && composer dump-autoload

# Copy everything
COPY . .

EXPOSE 80

CMD ["apache2-foreground"]