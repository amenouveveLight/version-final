# Utilise une image préconfigurée avec Nginx et PHP-FPM optimisée
FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Configuration de l'image Docker
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Configuration Laravel de base pour la production
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Autoriser composer à s'exécuter en tant que root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]