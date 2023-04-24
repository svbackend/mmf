FROM php:7.4-fpm-alpine3.13

RUN apk add --no-cache autoconf g++ make icu-dev \
  && pecl install xdebug-2.9.8 \
  && rm -rf /tmp/pear \
  && docker-php-ext-enable xdebug

# Add Imagick Extension
RUN apk add --no-cache imagemagick imagemagick-dev \
  && pecl install imagick \
  && rm -rf /tmp/pear \
  && docker-php-ext-enable imagick

RUN docker-php-ext-install mysqli pdo pdo_mysql intl bcmath && docker-php-ext-enable pdo_mysql intl bcmath

RUN docker-php-ext-install mysqli pdo pdo_mysql intl && docker-php-ext-enable pdo_mysql intl

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

RUN apk add --no-cache \
  zip unzip libzip-dev php7-zip freetype libpng openssl-dev openssl imap-dev \
  libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-configure zip && \
  NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
  docker-php-ext-install -j${NPROC} gd && \
  docker-php-ext-install zip && \
  apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev libzip-dev openssl-dev

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./conf.d /usr/local/etc/php/conf.d

WORKDIR /app

COPY ./entrypoint.sh /usr/local/bin/docker-php-entrypoint

RUN chmod +x /usr/local/bin/docker-php-entrypoint
