# Используйте базовый образ Ubuntu
FROM ubuntu:20.04

# Установите необходимые пакеты
RUN apt-get update && apt-get install -y \
    wget \
    build-essential \
    libevent-dev \
    libsasl2-dev \
    git

# Определите переменные окружения для версий Memcached и Repcached
ENV MEMCACHED_VERSION 1.6.9
ENV REPCACHED_VERSION 2.3.1

# Скачайте и распакуйте исходный код Memcached
RUN wget http://www.memcached.org/files/memcached-$MEMCACHED_VERSION.tar.gz \
    && tar -zxvf memcached-$MEMCACHED_VERSION.tar.gz

# Скачайте и распакуйте исходный код Repcached
RUN wget https://github.com/Hitachi/Repcached/archive/$REPCACHED_VERSION.tar.gz \
    && tar -zxvf $REPCACHED_VERSION.tar.gz

# Примените патч Repcached к исходному коду Memcached
RUN cd memcached-$MEMCACHED_VERSION \
    && patch -p1 < ../Repcached-$REPCACHED_VERSION/repcached-$REPCACHED_VERSION.patch

# Скомпилируйте и установите Memcached с патчем Repcached
RUN cd memcached-$MEMCACHED_VERSION \
    && ./configure --enable-replication \
    && make \
    && make install

# Очистите контейнер от неиспользуемых файлов
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Определите порт, который будет прослушивать Memcached
EXPOSE 11211

# Запустите Memcached при старте контейнера
CMD ["memcached", "-u", "root", "-m", "64", "-p", "11211", "-X", "11212", "-vv"]
