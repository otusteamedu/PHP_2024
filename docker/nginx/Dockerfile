FROM nginx:latest

COPY ./conf.d/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /var/www

VOLUME /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]