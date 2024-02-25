FROM nginx:1.25.2-alpine

COPY nginx.conf /etc/nginx/
COPY default.conf /etc/nginx/conf.d

RUN apk update && apk upgrade && apk add --no-cache bash

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
