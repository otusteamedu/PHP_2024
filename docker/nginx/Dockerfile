FROM nginx:1.24-alpine
LABEL authors="hukimato"

COPY ./mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]