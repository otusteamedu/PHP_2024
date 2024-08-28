FROM nginx

COPY ./application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /data

CMD [ "nginx", "-g", "daemon off;" ]