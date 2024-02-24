FROM nginx:1.25

ARG CUSTOM_HOST
ENV CUSTOM_HOST ${CUSTOM_HOST}

COPY hosts/site.conf /etc/nginx/conf.d/site.conf

# этот файл потом будет включен в конфиг хоста
RUN echo "    server_name ${CUSTOM_HOST};" > /etc/nginx/inc_server_name.conf

# в целях отладки.
#RUN apt-get update  && apt-get install -y iputils-ping iproute2 mc

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
