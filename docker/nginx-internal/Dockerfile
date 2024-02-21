FROM nginx:1.25.3

COPY ./config/hosts/application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /app/application.local

CMD ["nginx", "-g", "daemon off;"]