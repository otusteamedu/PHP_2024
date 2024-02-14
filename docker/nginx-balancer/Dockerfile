ARG NGINX_VERSION=1.25.3

FROM nginx:${NGINX_VERSION}

COPY docker/nginx-balancer/default.conf /etc/nginx/conf.d/

EXPOSE 80
EXPOSE 443
