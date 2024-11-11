FROM nginx:latest

ARG UID
RUN addgroup --gid $UID --system app \
      && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

COPY ./hosts/nginx.conf /etc/nginx/nginx.conf
COPY ./hosts/unix-sockets-mysite.local.conf /etc/nginx/conf.d/unix-sockets-mysite.local.conf
#COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data  

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]