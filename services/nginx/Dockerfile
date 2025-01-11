FROM nginx:1.27.3

COPY conf.d/nginx_web_server.conf /etc/nginx/templates/default.conf.template

WORKDIR /var/www/mysite.local

VOLUME /var/www/mysite.local

CMD ["nginx", "-g", "daemon off;"]