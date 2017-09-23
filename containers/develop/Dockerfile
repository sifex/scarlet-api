FROM ubuntu:16.04

LABEL maintainer="Alisdair Robertson <alisdair.w.robertson@gmail.com>"

RUN apt-get update \
    && \
    DEBIAN_FRONTEND=noninteractive apt-get upgrade -y \
    && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y curl \
    && \
    apt-get clean \
    && \
    curl -sL https://deb.nodesource.com/setup_6.x | bash -

RUN apt-get update \
    && \
    DEBIAN_FRONTEND=noninteractive apt-get upgrade -y \
    && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
    zip \
    unzip \
    php7.0 \
    php7.0-mysql \
    php7.0-mbstring \
    php7.0-dom \
    php7.0-curl \
    php7.0-zip \
    php7.0-gd \
    composer \
    nodejs \
    && \
    apt-get clean

RUN npm install -g bower pm2 && npm cache clean

RUN cd /srv && composer update

ENTRYPOINT cd /srv && pm2 start php -- artisan serve --host 0.0.0.0 && pm2 start npm -- run watch && /bin/bash