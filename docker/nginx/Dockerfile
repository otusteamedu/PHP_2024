FROM nginx

COPY ./conf.d/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]