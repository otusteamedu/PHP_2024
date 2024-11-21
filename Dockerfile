FROM ubuntu:latest

RUN apt-get update && apt-get -y install \
    bc

COPY sum.sh ./app/

RUN chmod +x /app/sum.sh

ENTRYPOINT ["./app/sum.sh"]