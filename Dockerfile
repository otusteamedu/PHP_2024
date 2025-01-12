# Используем официальный образ Ubuntu
FROM alpine:latest

# Устанавливаем необходимые пакеты
RUN apk add --no-cache bash

# Устанавливаем рабочую директорию
WORKDIR /app

# Копируем скрипты и файл с таблицей
COPY sum.sh /app/sum.sh
COPY cities.sh /app/cities.sh
COPY users.list /app/users.list

# Делаем скрипты исполняемыми
RUN chmod +x /app/sum.sh
RUN chmod +x /app/cities.sh
