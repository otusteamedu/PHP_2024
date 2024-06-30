FROM nginx:latest

COPY ./nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]