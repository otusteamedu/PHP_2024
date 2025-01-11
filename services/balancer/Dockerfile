FROM nginx:1.27.3

COPY conf.d/nginx_balancer.conf /etc/nginx/conf.d/nginx_balancer.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]