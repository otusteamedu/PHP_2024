FROM nginx:latest

COPY hosts/site.conf /etc/nginx/conf.d/site.conf
COPY hosts/inc_server_name.conf /etc/nginx/inc_server_name.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
