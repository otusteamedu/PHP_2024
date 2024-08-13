FROM nginx

COPY ./conf.d/ /etc/nginx/conf.d/

WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]