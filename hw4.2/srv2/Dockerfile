FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]