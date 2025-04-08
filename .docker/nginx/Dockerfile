FROM nginx:latest

COPY ./hosts/otus.local.conf /etc/nginx/conf.d/otus.local.conf

WORKDIR /var/www/html

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
