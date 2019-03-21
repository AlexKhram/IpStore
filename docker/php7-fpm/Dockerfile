# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM php:7.1-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip

## Add commanduser
RUN addgroup --uid 1000 commanduser \
    && adduser --system --uid 1000 --gid 1000 --disabled-password commanduser \
    && chown -R 1000:1000 /home/commanduser

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql

# install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# install symfony installer
#RUN cd /usr/local/bin && curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony \
#    && chmod a+x /usr/local/bin/symfony && chown 1000:1000 /usr/local/bin/symfony

WORKDIR /var/www/app
