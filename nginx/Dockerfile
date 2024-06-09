FROM nginx:latest

COPY ./hosts/myfirst.docker.conf /etc/nginx/conf.d/myfirst.docker.conf

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]