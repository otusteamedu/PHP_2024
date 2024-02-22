FROM nginx:latest

COPY mysite.local.config /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data

CMD ["nginx", "-g", "daemon off;"]
