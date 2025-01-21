# Use PHP 8.2 FPM with Alpine as the base image
FROM php:8.2-fpm-alpine

# Add custom PHP-FPM configuration
ADD ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Add a new group and user for the application
RUN addgroup -g 1000 signature && adduser -G signature -g signature -s /bin/sh -D signature

# Create the application directory
RUN mkdir -p /var/www/html

# Copy application source code to the container
ADD ./src/ /var/www/html

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set ownership of the application directory
RUN chown -R signature:signature /var/www/html

# Switch to the application user
USER signature

# Set the working directory
WORKDIR /var/www/html

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
