FROM ronisaha/php-8-debain:fpm-8.2.8

RUN docker-php-ext-install pdo pdo_mysql bcmath opcache

# Install unzip utility and libs needed by zip PHP extension
RUN apt-get update && apt-get install -y \
    curl \
    build-essential \
    openssl \
    libssl-dev \
    zlib1g-dev \
    libzip-dev \
    ca-certificates \
    unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install zip

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get update && apt-get install nodejs -y

RUN ls -al
# RUN npm install

EXPOSE 9000

ENTRYPOINT ["php-fpm"]
