FROM nginx

COPY ./otusphp.local.conf /etc/nginx/conf.d/otusphp.local.conf

WORKDIR /app

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

