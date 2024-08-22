FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx
RUN useradd -s /bin/bash -u 1001 nginx

# Устанавливаем текстовые редакторы
RUN apt-get update && apt-get install -y vim nano

COPY ./hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]