FROM php:8.3-apache

# mysqli for the database, rewrite for clean URLs
RUN docker-php-ext-install mysqli \
    && a2enmod rewrite headers

# The app's web root is the project folder
COPY ["Banking Managment System/", "/var/www/html/"]

RUN chown -R www-data:www-data /var/www/html

# Render sets $PORT; default to 80 locally
CMD ["bash", "-c", "sed -i \"s/Listen 80/Listen ${PORT:-80}/\" /etc/apache2/ports.conf && sed -i \"s/:80>/:${PORT:-80}>/\" /etc/apache2/sites-enabled/000-default.conf && exec apache2-foreground"]
