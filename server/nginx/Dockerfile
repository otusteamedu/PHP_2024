FROM nginx:latest

COPY ./hosts/test.local.conf /etc/nginx/conf.d/test.local.conf

WORKDIR /data/app

VOLUME /data/app

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]