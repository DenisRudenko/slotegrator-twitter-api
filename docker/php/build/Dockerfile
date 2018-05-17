FROM php:7.1.8-fpm

ENV TZ=Europe/Kiev
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Устонавливаем необходимые библиотеки Yii2
RUN apt-get update && apt-get install -y \
        g++ \
        git \
        libicu-dev \
        libmcrypt-dev \
        libfreetype6-dev \
        libjpeg-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        zlib1g-dev \
        mysql-client \
        openssh-client \
        libxml2-dev \
        libcurl4-openssl-dev \
        libssl-dev \
        pkg-config \
        # Удаляем лишне
        && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
        # Устанавливаем расширения PHP
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/ \
    && docker-php-ext-configure bcmath \
    && docker-php-ext-install \
        gd \
        intl \
        pdo_mysql \
        mbstring \
        mcrypt \
        opcache \
        zip \
        bcmath \
        soap \
    && pecl install apcu-5.1.8 && echo extension=apcu.so > /usr/local/etc/php/conf.d/apcu.ini \
    && pecl install mongodb && echo extension=mongodb.so > /usr/local/etc/php/conf.d/mongodb.ini

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
    composer clear-cache

# Install composer plugins
RUN composer global require --optimize-autoloader \
        "hirak/prestissimo:^0.3.7" && \
    composer global dumpautoload --optimize && \
    composer clear-cache

ARG GITHUB_TOKEN
RUN composer config -g github-oauth.github.com $GITHUB_TOKEN

WORKDIR /var/www