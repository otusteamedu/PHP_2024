FROM nginx:latest

COPY ./hosts/default.conf /etc/nginx/conf.d/

WORKDIR /var/www/html/

VOLUME /var/www/html/

#EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]