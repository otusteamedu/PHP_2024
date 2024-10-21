FROM php:8.2.20-cli

#RUN apt-get update && apt-get install -y unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


ARG ELASTIC_HOST_ARG
ENV ELASTIC_HOSTS=$ELASTIC_HOST_ARG
ARG ELASTIC_PASSWORD_ARG
ENV ELASTIC_PASSWORD=$ELASTIC_PASSWORD_ARG

RUN echo $ELASTIC_HOST_ARG/_bulk;

# не отрабатывает копирование из соседней папки  /data/books.json Почему?
#COPY ./../../data/books.json /data/books2.json
# Копирование из текущей папки работает
COPY ./books.json /data/books.json
WORKDIR /code/public
# Выдает ошибку, так как RUN отрабатывает во время сборки образа, а эластик ещё не запущен
#RUN curl $ELASTIC_HOST_ARG/_bulk -H "Content-Type: application/json" --data-binary @/data/books.json -u elastic:$ELASTIC_PASSWORD_ARG

#Когда расскомментирую след. строку, то индекс создается, но! контейнер закрывается. Почему? Ведь, при описании контейнера, я указал
#    stdin_open: true
#    tty: true
#CMD curl $ELASTIC_HOSTS/_bulk -H "Content-Type: application/json" --data-binary @/data/books.json -u elastic:$ELASTIC_PASSWORD
