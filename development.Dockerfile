FROM alpine:latest

MAINTAINER andreas4all <andreas4all@users.noreply.github.com>

ENV TERM xterm

WORKDIR /usr/src/app

RUN apk update && \
    apk upgrade && \
    apk add make curl php7 php7-pdo_pgsql php7-pgsql php7-zip php7-bcmath php7-dom php7-xml \
        php7-curl php7-session php7-opcache php7-redis php7-json php7-phar php7-mongodb \
        php7-iconv php7-openssl php7-tokenizer php7-zlib php7-mbstring bash mc make yarn git && \
    mkdir log pid && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
    composer global require hirak/prestissimo && \
    php -v && \
    php -m
