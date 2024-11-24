FROM nginx

COPY ./hosts/hw4.local.conf /etc/nginx/conf.d/hw4.local.conf

WORKDIR /app/hw4.local

# VOLUME /app/hw4.local

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]