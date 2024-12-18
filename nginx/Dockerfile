FROM nginx:latest

COPY ./nginx/hosts/hw5.conf /etc/nginx/conf.d/hw5.conf

WORKDIR /data/hw5

VOLUME /data/hw5

EXPOSE 80

RUN usermod -aG www-data nginx

CMD ["nginx", "-g", "daemon off;"]