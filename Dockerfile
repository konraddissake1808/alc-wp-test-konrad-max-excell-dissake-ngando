FROM wordpress:latest

COPY wp-content /var/www/html/wp-content

RUN chown -R www-data:www-data /var/www/html/wp-content

EXPOSE 80
