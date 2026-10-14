#!/bin/bash
set -e
# Render provides $PORT; listen on it (default 80 locally).
sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf
sed -i "s/:80>/:${PORT:-80}>/" /etc/apache2/sites-enabled/000-default.conf

if [ "$APP_ENV" = "production" ]; then
  # Cookies only over HTTPS; hide the PHP version.
  printf 'session.cookie_secure = 1\nexpose_php = Off\n' > /usr/local/etc/php/conf.d/zz-production.ini
fi
exec apache2-foreground
