ARG NGINX_BASEIMAGE_VERSION

FROM nginx:${NGINX_BASEIMAGE_VERSION}-alpine as base

ARG TIME_ZONE
ARG USER_ID
ARG GROUP_ID

ENV TZ=${TIME_ZONE}
RUN apk update && \
    apk add shadow && \
    usermod -u ${USER_ID} nginx && groupmod -g ${GROUP_ID} nginx && \
    apk del shadow && \
    rm -rf /var/cache/apk/*

COPY ./nginx/default.conf.template /etc/nginx/templates/

WORKDIR /app/
