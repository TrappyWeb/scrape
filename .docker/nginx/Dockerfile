FROM nginx:1.29

COPY .docker/nginx/default.prod.conf /etc/nginx/conf.d/default.conf
COPY --chown=www-data . /var/www/html
