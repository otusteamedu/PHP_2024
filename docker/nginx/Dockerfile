FROM ubuntu:latest  

RUN apt-get update  
RUN apt-get install -y nginx  

WORKDIR /data 

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]