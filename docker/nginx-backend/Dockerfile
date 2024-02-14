ARG NGINX_VERSION=1.25.3

FROM nginx:${NGINX_VERSION}

ARG FAST_CGI_HOSTNAME

COPY docker/nginx-backend/default.conf /etc/nginx/conf.d/

EXPOSE 80
EXPOSE 443
