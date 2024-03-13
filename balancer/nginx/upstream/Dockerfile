FROM nginx:latest

COPY ./test.local.conf /etc/nginx/conf.d/test.local.conf

VOLUME /data/app/public

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]