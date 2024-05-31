FROM nginx:latest

COPY ./test.local.conf /etc/nginx/conf.d/test.local.conf

WORKDIR /data/app/public

VOLUME /data/app/public

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]