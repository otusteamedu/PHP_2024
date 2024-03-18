FROM nginx:latest

COPY ./hosts/otus-edu.localhost.conf /etc/nginx/conf.d/otus-edu.localhost.conf

WORKDIR /var/www/html

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
