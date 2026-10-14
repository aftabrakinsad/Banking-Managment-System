FROM php:8.3-apache

# mysqli for the database, rewrite for clean URLs
RUN docker-php-ext-install mysqli \
    && a2enmod rewrite headers

COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/sessions.conf /etc/apache2/conf-available/sessions.conf
RUN a2enconf sessions
COPY docker/security.conf /etc/apache2/conf-available/security-app.conf
RUN a2enconf security-app

# The app's web root is the project folder
COPY ["Banking Managment System/", "/var/www/html/"]

RUN chown -R www-data:www-data /var/www/html

# Render sets $PORT; default to 80 locally
CMD ["bash", "-c", "sed -i \"s/Listen 80/Listen ${PORT:-80}/\" /etc/apache2/ports.conf && sed -i \"s/:80>/:${PORT:-80}>/\" /etc/apache2/sites-enabled/000-default.conf && exec apache2-foreground"]
