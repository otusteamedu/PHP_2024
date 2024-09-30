FROM nginx

COPY nginx.local.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

CMD [ "nginx", "-g", "daemon off;" ]