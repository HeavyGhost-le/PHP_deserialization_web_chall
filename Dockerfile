FROM php:8.2-apache

# Set Apache to listen on port 8081
RUN sed -i 's/Listen 80/Listen 8081/g' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8081>/g' /etc/apache2/sites-available/000-default.conf

# Install PHP intl extension
RUN apt-get update && \
    apt-get install -y libicu-dev && \
    docker-php-ext-install intl && \
    rm -rf /var/lib/apt/lists/*

# Harden PHP settings
RUN echo "disable_functions = exec,passthru,shell_exec,system,proc_open,popen" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "allow_url_include = Off" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "expose_php = Off" >> /usr/local/etc/php/conf.d/security.ini

# Copy application
COPY web/ /var/www/html/

# Create flag
RUN echo "acsctf{realistic_php_obj_injection_ftw}" > /var/www/html/flag.txt && \
    chown root:www-data /var/www/html/flag.txt && \
    chmod 640 /var/www/html/flag.txt

# Set permissions
RUN chmod 640 /var/www/html/*.php && \
    chmod 660 /var/www/html/assets/logs.txt || true && \
    chown www-data:www-data /var/www/html/assets/logs.txt || true

EXPOSE 8081
