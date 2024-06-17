FROM postgres:16.3

ADD functions.sql /docker-entrypoint-initdb.d/init.sql
ADD init.sql /docker-entrypoint-initdb.d/functions.sql
ADD init.sh /docker-entrypoint-initdb.d/init.sh

EXPOSE 5432

CMD ["postgres"]