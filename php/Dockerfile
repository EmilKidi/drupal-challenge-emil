FROM phusion/baseimage:18.04-1.0.0 AS php-base-image

# Variables.
ENV COMPOSER_VERSION="1.10.8"
ENV PHP_FPM_PORT="9000"

# Add an unofficial APT repository for PHP as we cannot use the official ones.
RUN add-apt-repository ppa:ondrej/php

RUN \
  apt-get -q update && \
  apt-get -q install \
    libssl-dev \
    wget \
    nano \
    jq \
    zip \
    unzip \
    php7.3-common \
    php7.3-opcache \
    php7.3-readline \
    php7.3-cli \
    php7.3-curl \
    php7.3-dev \
    php7.3-fpm \
    php7.3-gd \
    php7.3-json \
    php7.3-ldap \
    php7.3-mbstring \
    php7.3-memcached \
    php7.3-mongodb \
    php7.3-mysql \
    php-pear \
    php7.3-redis \
    php7.3-soap \
    php7.3-tidy \
    php7.3-xml \
    php7.3-zip \
    php7.3-xdebug \
      -y -o Dpkg::Options::="--force-confold" && \
  apt-get -q autoremove \
    -y -o Dpkg::Options::="--force-confold" && \
  apt-get -q clean

# Enable the supported PHP extensions.
RUN \
  phpenmod curl && \
  phpenmod dom && \
  phpenmod gd && \
  phpenmod json && \
  phpenmod ldap && \
  phpenmod mbstring && \
  phpenmod memcached && \
  phpenmod mongodb && \
  phpenmod mysqlnd && \
  phpenmod opcache && \
  phpenmod pdo && \
  phpenmod pdo_mysql && \
  phpenmod pdo_sqlsrv && \
  phpenmod redis && \
  phpenmod simplexml && \
  phpenmod soap && \
  phpenmod sockets && \
  phpenmod sqlsrv && \
  phpenmod tidy && \
  phpenmod wddx && \
  phpenmod xml && \
  phpenmod xdebug

# Remove the default PHP-FPM pools as they will not be used.
RUN \
  rm -rf /etc/php/7.3/fpm/pool.d/*

# Transfer the etc directory from the host to the container.
COPY /etc/ /etc/

# Bake app into docker image.
COPY / /app/

# Enable access to the php-fpm service for kubernetes.
RUN chmod +x /etc/service/php-fpm/run

# Install composer and add the vendor bin directory to the PATH variable.
RUN \
  wget -q "https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar" \
    && \
  mv composer.phar /usr/local/bin/composer && \
  chmod +x /usr/local/bin/composer

ENV PATH="${PATH}:/root/.composer/vendor/bin"

# Ensure that the service symlink is working.
RUN \
  rm -rf /etc/service && \
  ln -sf /etc/runit/runsvdir/default /etc/service
