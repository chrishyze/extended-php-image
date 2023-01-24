FROM php:8.2-fpm-alpine

LABEL version="1.0"
LABEL org.opencontainers.image.authors="chrishyze@gmail.com"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions apcu bcmath bz2 event exif gd gnupg imagick memcached mongodb mysqli opcache pcntl pdo_mysql pdo_pgsql pgsql protobuf redis sockets ssh2 swoole xdebug zip zstd &&\
    rm -f /usr/local/etc/php/conf.d/*.ini
