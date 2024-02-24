FROM nginx:1.25

COPY hosts/site.conf /etc/nginx/conf.d/site.conf

# в целях отладки.
#RUN apt-get update  && apt-get install -y iputils-ping iproute2 mc

CMD ["nginx", "-g", "daemon off;"]
