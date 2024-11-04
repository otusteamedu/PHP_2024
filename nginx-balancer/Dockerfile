FROM nginx:latest

COPY ./hosts/local.conf /etc/nginx/conf.d/local.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]