FROM nginx:latest

COPY hosts/balancer.otus.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]