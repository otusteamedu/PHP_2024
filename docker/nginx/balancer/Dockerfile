FROM nginx:latest

COPY ./dev.otus.conf /etc/nginx/conf.d/dev.otus.conf

WORKDIR /data

VOLUME /data

CMD ["nginx", "-g", "daemon off;"]