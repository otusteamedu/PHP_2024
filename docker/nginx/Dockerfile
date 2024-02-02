FROM ubuntu:latest

RUN apt-get update

RUN apt-get install -y nginx

COPY ./sites-enabled/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
