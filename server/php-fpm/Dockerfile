FROM php:8.1.0-fpm-alpine

#AMQP
ENV EXT_AMQP_VERSION=master

RUN docker-php-source extract \
    && apk -Uu add git rabbitmq-c-dev \
    && git clone --branch $EXT_AMQP_VERSION --depth 1 https://github.com/php-amqp/php-amqp.git /usr/src/php/ext/amqp \
    && cd /usr/src/php/ext/amqp && git submodule update --init \
    && docker-php-ext-install amqp

# Install packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash
RUN apk add --update linux-headers

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev \
    rabbitmq-c-dev \
    rabbitmq-c \
    supervisor \
    libzip-dev \
    bash \
    wget \
    nano

#RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
        #&& pecl install redis \
       # && docker-php-ext-enable redis.so

## Postgres
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql


# Xdebug
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY php.ini /usr/local/etc/php/conf.d/php.ini

RUN mkdir -p /var/log/supervisor

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

USER www-data

# Source code
COPY ./ /var/www
WORKDIR /var/www

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm

EXPOSE 9000
