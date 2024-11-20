FROM banian/nginx-extras

USER root

RUN apt-get update && apt-get -y --no-install-recommends install \
    wget  \
    make

CMD ["/bin/sh", "-c", "nginx -g 'daemon off;'"]
