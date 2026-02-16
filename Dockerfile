FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pgsql pdo_pgsql

# Verify extension installation
RUN php -m | grep pgsql

WORKDIR /app
COPY . /app

CMD php -S 0.0.0.0:$PORT -t /app
