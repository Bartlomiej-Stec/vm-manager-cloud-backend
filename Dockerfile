FROM php:8.3-fpm

# Install necessary system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    librdkafka-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install rdkafka extension via PECL, if not already installed
RUN if ! pecl list | grep -q rdkafka; then \
      pecl install rdkafka && \
      docker-php-ext-enable rdkafka; \
    else \
      echo "rdkafka already installed"; \
    fi

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www

# Copy the application code
COPY . .

# Set the proper permissions for Laravel
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www 
RUN chmod -R 777 /var/www/storage

EXPOSE 9000

CMD ["php-fpm"]
