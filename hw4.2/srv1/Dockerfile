FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf
#COPY ./mysite.local.conf /etc/nginx/conf.d/mysite.local.conf
#COPY ./index.html /data/mysite.local/index.html

WORKDIR /data  

VOLUME /data  

EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]
