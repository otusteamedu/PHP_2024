FROM nginx:latest

ADD docker/nginx/vhost.conf  /etc/nginx/conf.d/default.conf

WORKDIR /var/www/laravel-docker


CMD ["nginx", "-g", "daemon off;"]