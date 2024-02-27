FROM nginx:1.25.2-alpine

#COPY ../nginx-proxy/nginx.conf /etc/nginx/
#COPY ../nginx-proxy/default.conf /etc/nginx/conf.d

RUN apk update && apk upgrade

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
