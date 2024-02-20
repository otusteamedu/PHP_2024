FROM nginx:1.25.3

COPY ./config/hosts/entry.conf /etc/nginx/conf.d/entry.conf

CMD ["nginx", "-g", "daemon off;"]