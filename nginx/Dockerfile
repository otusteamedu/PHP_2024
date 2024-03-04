FROM nginx:latest

COPY ./hosts/test.local.conf /etc/nginx/conf.d/test.local.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]