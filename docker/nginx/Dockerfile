FROM nginx:1.27

COPY ./test.local.conf /etc/nginx/conf.d/test.local.conf

WORKDIR /var/www/test.local/public

VOLUME /var/www/test.local/public

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]