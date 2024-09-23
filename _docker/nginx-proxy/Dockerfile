FROM nginx:latest

COPY ./application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
