FROM php:8.2-fpm-alpine

RUN set -xe \
    && docker-php-ext-install pdo pdo_mysql

#
# Configure user
#
ENV DOCKER_USER=www

ENV DOCKER_UID=1000
ENV DOCKER_GID=1000

#
# Add host user and group into container
#
RUN set -xe \
		&& addgroup -g $DOCKER_GID $DOCKER_USER \
		&& adduser -g "web user" -s /bin/sh -D -u $DOCKER_UID -G $DOCKER_USER $DOCKER_USER \
		&& delgroup $DOCKER_USER $DOCKER_USER \
		&& echo "$DOCKER_USER:$DOCKER_USER" | chpasswd

#
# Set working directory
#
WORKDIR /www

#
# Run php-fpm with docker user
# Increase memory limit for php
# Install composer
# Link composer cache into project folder
#
ENV COMPOSER_VERSION=2.5.1
ENV COMPOSER_HOME=/home/.composer

RUN set -xe \
		&& echo -e "\n[www]\nuser = $DOCKER_USER\ngroup = $DOCKER_USER" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
		&& echo -e "memory_limit=-1\n" > /usr/local/etc/php/conf.d/memory.ini \
	\
		&& curl https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION \
        && chown -R $DOCKER_USER:$DOCKER_USER $COMPOSER_HOME

