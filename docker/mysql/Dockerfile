FROM mysql:8

ADD dump.sql /etc/mysql/dump.sql

RUN cp /etc/mysql/dump.sql /docker-entrypoint-initdb.d
