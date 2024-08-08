FROM nginx:latest

ADD docker/nginx/vhost.conf  /etc/nginx/conf.d/default.conf

WORKDIR /data


CMD ["nginx", "-g", "daemon off;"]