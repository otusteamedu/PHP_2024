FROM ubuntu:latest  
RUN apt-get update
RUN apt-get install -y nginx
COPY sites-enabled/otus.lcl.conf /etc/nginx/sites-enabled/otus.lcl.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]