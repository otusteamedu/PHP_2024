FROM nginx:latest

COPY mysite.local.config /etc/nginx/conf.d/mysite.local.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
