FROM nginx:1.27.0-alpine

COPY ./dev.otus.conf /etc/nginx/conf.d/dev.otus.conf

WORKDIR /data

EXPOSE 80

CMD [ "nginx", "-g", "daemon off;" ]