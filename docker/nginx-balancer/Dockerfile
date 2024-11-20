FROM nginx:1.27-alpine

COPY ./mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data

CMD [ "nginx", "-g", "daemon off;" ]