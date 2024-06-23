FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /var/www/html/

VOLUME /var/www/html/

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]