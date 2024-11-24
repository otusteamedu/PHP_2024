FROM nginx

WORKDIR /data

COPY ./hosts/hw4.local.conf /etc/nginx/conf.d/hw4.local.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]