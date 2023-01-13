FROM php:8.2-fpm-alpine3.17
LABEL maintainer="Tim Aerdts (INOVA) <tim@teaminova.nl>"

RUN apk update && apk add --no-cache \
    shadow \
    curl

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
        install-php-extensions pdo_mysql opcache mcrypt redis intl sysvsem zip bcmath gd exif pcntl soap imagick xmlrpc

RUN adduser -D -h /home/php -u 1000 php && \
    /usr/sbin/usermod -u 1000 php && \
    /usr/sbin/usermod -s /bin/ash php && \
    /usr/sbin/usermod -m -d /home/php php && \
    chown -R php /var/log && \
    chmod -R g+w /var/log

USER php
