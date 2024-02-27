FROM nginx:1.25.2-alpine

RUN apk update && apk upgrade

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
