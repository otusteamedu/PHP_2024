FROM nginx

RUN set -x \
        && deluser www-data \
        && addgroup -gid 500 --system www-data \
        && adduser -uid 500 --system --disabled-login --disabled-password --gid 500 www-data

COPY ./otusphp.local.conf /etc/nginx/conf.d/otusphp.local.conf

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]