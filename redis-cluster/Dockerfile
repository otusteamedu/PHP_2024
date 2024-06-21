FROM redis:7.2.3

COPY redis.conf /usr/local/etc/redis/redis.conf
COPY redis-cluster-create.sh /usr/local/bin/redis-cluster-create.sh
RUN chmod +x /usr/local/bin/redis-cluster-create.sh

CMD "/usr/local/bin/redis-cluster-create.sh"