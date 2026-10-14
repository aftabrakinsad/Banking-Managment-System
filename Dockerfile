FROM php:8.3-apache

# mysqli for the database; headers/rewrite for Apache
RUN docker-php-ext-install mysqli \
    && a2enmod rewrite headers

COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/sessions.conf /etc/apache2/conf-available/sessions.conf
COPY docker/security.conf /etc/apache2/conf-available/security-app.conf
RUN a2enconf sessions security-app

# The app's web root is the project folder; schema + loader live outside it
COPY ["Banking Managment System/", "/var/www/html/"]
COPY db/init /opt/db/init
COPY scripts /opt/scripts
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && chown -R www-data:www-data /var/www/html

CMD ["/usr/local/bin/entrypoint.sh"]
