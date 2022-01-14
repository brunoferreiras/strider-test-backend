# Set the base image for subsequent instructions
FROM php:8.0.10-fpm-alpine as base
WORKDIR /var/www/html

ENV TZ=UTC \
    TERM=xterm-256color \
    COLORTERM=truecolor \
    PHP_FPM_DIR=/usr/local/etc/php-fpm.d

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

# Add and set Group
RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel && \
    # Create folder to run
    mkdir -p /var/www/html && \
    # Set Profile
    chown laravel:laravel /var/www/html && \
    # Update packages
    apk update && \
    apk add --update tzdata && \
    ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && \
    apk add --update \
    wget \
    curl \
    openssh \
    git \
    unzip \
    make \
    bash \
    libgomp \
    sudo && \
    # Preparing and Installing PHP
    install-php-extensions \
    gmp \
    gd \
    bcmath \
    bz2 \
    calendar \
    exif \
    pdo_mysql \
    zip \
    pcntl \
    opcache \
    xdebug \
    redis \
    intl && \
    # Install Supervisor
    apk add supervisor && \
    # Installing Composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    # Installing Tini
    wget -O /tini https://github.com/krallin/tini/releases/download/v0.18.0/tini-static && \
    chmod +x /tini && \
    # Cleaning up
    rm -rf /tmp/* && \
    rm -rf /var/cache/apk/*

#
# PHP Dependencies
#
FROM composer:2.1 as vendor

COPY composer.json composer.lock /app/
COPY database/ database/

ENV PATH /composer/vendor/bin:$PATH

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --no-dev \
    --no-autoloader \
    --profile

FROM base
WORKDIR /var/www/html

USER laravel

COPY --chown=laravel:laravel . /var/www/html
COPY --chown=laravel:laravel --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --chown=laravel:laravel ./docker/php/supervisord.conf /etc/supervisord.conf

# Environment variables
ENV PATH=/home/laravel/.composer/vendor/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

ADD docker/php/entrypoint.sh /bin/entrypoint.sh

ENTRYPOINT ["/tini", "--", "/bin/entrypoint.sh"]

CMD ["bash"]
