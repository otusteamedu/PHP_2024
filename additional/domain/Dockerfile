FROM nginx

COPY ./mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

COPY ./index.html /data/mysite.local/index.html

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

# docker build -t sf/nginx .
# docker run -d -p 80:80 sf/nginx