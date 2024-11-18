FROM nginx:latest

COPY ./nginx/hosts/hw1.local.conf /etc/nginx/conf.d/hw1.local.conf

WORKDIR /data/hw1.local

VOLUME /data/hw1.local

EXPOSE 80

RUN usermod -aG www-data nginx

CMD ["nginx", "-g", "daemon off;"]