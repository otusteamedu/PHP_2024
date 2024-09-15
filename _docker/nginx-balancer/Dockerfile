FROM nginx

COPY ./mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /var/www

CMD [ "nginx", "-g", "daemon off;" ]
