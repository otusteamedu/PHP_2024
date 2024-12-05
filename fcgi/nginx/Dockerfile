FROM nginx:latest

COPY ./hosts/site.local.conf /etc/nginx/conf.d/site.local.conf

WORKDIR /data/site.local

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
