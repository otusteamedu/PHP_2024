FROM nginx:latest

COPY ./hosts/otus-hw6.conf /etc/nginx/conf.d/default.conf

WORKDIR /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]