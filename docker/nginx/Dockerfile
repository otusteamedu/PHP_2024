FROM nginx:latest
LABEL authors="Viktor Rikhert"

COPY default.conf /etc/nginx/conf.d

RUN mkdir  -p "/var/run/php"

WORKDIR /data
VOLUME /data