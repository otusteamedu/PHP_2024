FROM nginx:latest

COPY hosts/otus.local.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

CMD ["nginx", "-g", "daemon off;"]