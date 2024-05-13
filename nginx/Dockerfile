FROM nginx

COPY hosts/mysite.local.conf /etc/nginx/conf.d/default.conf
WORKDIR /DATA
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
