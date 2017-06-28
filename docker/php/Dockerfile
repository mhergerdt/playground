FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    vim \
    # git
    git \
    # intl dependencies
    zlib1g-dev \
    libicu-dev

RUN pecl install xdebug-2.5.1 \
    && docker-php-ext-install intl pdo pdo_mysql mbstring pcntl \
    && docker-php-ext-enable opcache xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD symfony.ini /usr/local/etc/php/conf.d/symfony.ini

RUN usermod -u 1000 www-data

#set token for private fastlane repositories
COPY auth.json /var/www/.composer/auth.json

WORKDIR /var/www/project

RUN chown -R www-data:www-data /var/www

USER www-data

RUN echo 'alias grep="grep --color=auto"' >> ~/.bashrc \
    && echo 'alias l="ls -CF"' >> ~/.bashrc \
    && echo 'alias la="ls -A"' >> ~/.bashrc \
    && echo 'alias lah="ls -alFthr --color=auto"' >> ~/.bashrc \
    && echo 'alias ll="ls -alF"' >> ~/.bashrc \
    && echo 'alias ls="ls --color=auto"' >> ~/.bashrc \
    && echo 'alias sf="php app/console"' >> ~/.bashrc \
    && echo 'alias ds="sf doctrine:migrations:status"' >> ~/.bashrc \
    && echo 'alias dd="sf doctrine:migrations:diff"' >> ~/.bashrc \
    && echo 'alias dm="sf doctrine:migrations:migrate"' >> ~/.bashrc \
    && echo 'alias dg="sf doctrine:migrations:generate"' >> ~/.bashrc \
    && echo 'alias cc="sf cache:clear"' >> ~/.bashrc \
    && echo 'alias ai="sf assets:install --symlink"' >> ~/.bashrc \
    && echo 'alias ad="sf assetic:dump"' >> ~/.bashrc

