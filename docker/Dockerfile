# Set master image
FROM php:7.3-fpm-alpine

# Auhtor
LABEL maintainer="Le Quang Vy <lequangvy2k@gmail.com>"

# Set working directory
WORKDIR /usr/share/nginx/html

# Install Additional dependencies
RUN apk update && apk add --no-cache \
  build-base shadow supervisor \
  php7-common \
  php7-pdo \
  php7-pdo_mysql \
  php7-mysqli \
  php7-mcrypt \
  php7-mbstring \
  php7-xml \
  php7-openssl \
  php7-json \
  php7-phar \
  php7-zip \
  php7-gd \
  php7-dom \
  php7-session \
  php7-zlib

# Add & Enable PDO for PHP connect MYSQL
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer 

# Clear cache
RUN rm -rf /var/cache/apk/*

# Copy existing app dir
COPY . . 

# Change app permission
RUN chown -R www-data:www-data .
