FROM postgres:16.0-alpine

COPY dump.sql /docker-entrypoint-initdb.d/
COPY seed.sql /docker-entrypoint-initdb.d/
