FROM php:8.3.21-apache

# Set proper timezone
ENV TZ=Europe/Paris

# Update and install necessary packages
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
    libzip-dev \
    zip \
    unzip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Configure PHP with secure settings
RUN echo "expose_php=Off" >> /usr/local/etc/php/php.ini && \
    echo "display_errors=Off" >> /usr/local/etc/php/php.ini && \
    echo "display_startup_errors=Off" >> /usr/local/etc/php/php.ini && \
    echo "log_errors=On" >> /usr/local/etc/php/php.ini && \
    echo "error_reporting=E_ALL" >> /usr/local/etc/php/php.ini && \
    echo "memory_limit=128M" >> /usr/local/etc/php/php.ini && \
    echo "max_execution_time=30" >> /usr/local/etc/php/php.ini && \
    echo "session.cookie_httponly=1" >> /usr/local/etc/php/php.ini && \
    echo "session.cookie_secure=1" >> /usr/local/etc/php/php.ini && \
    echo "session.use_strict_mode=1" >> /usr/local/etc/php/php.ini

# Configure Apache
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf && \
    echo "ServerSignature Off" >> /etc/apache2/apache2.conf && \
    a2enmod headers && \
    echo 'Header always set X-Content-Type-Options "nosniff"' >> /etc/apache2/apache2.conf && \
    echo 'Header always set X-XSS-Protection "1; mode=block"' >> /etc/apache2/apache2.conf

# Copy application files and set proper permissions
COPY src/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 555 {} \; && \
    find /var/www/html -type f -exec chmod 444 {} \;

# Use non-root user
USER www-data

EXPOSE 80
