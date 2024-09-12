FROM php:8.3-cli

RUN docker-php-ext-install sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

VOLUME /data
#ARG chatrole="server"
#RUN chatrole=${chatrole}
#RUN echo $chatrole
#CMD ["php", "./test.php", "--${chatrole}", "$chatrole", "chatrole"]

CMD ["php", "./app.php", "server"]
