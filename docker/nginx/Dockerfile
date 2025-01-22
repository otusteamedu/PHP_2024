FROM nginx

COPY ./otustgbot.local.conf /etc/nginx/conf.d/otustgbot.local.conf

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]