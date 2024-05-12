FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY ./hosts/irayu.conf /etc/nginx/sites-enabled/irayu.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 80
EXPOSE 443
CMD ["nginx", "-g", "daemon off;"]