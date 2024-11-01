FROM nginx

COPY ./mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

COPY ./index.html /data/mysite.local/index.html

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-d", "daemon off"]