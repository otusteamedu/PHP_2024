# Используем базовый образ Ubuntu
FROM ubuntu:latest

# Кладем файлы в tmp
COPY ./sum.sh /tmp/sum.sh
COPY cities.txt /tmp/cities.txt
COPY ./sort.sh /tmp/sort.sh

# Обновляем индексы и устанавливаем bc
#RUN apt update && apt install -y bc

# Устанавливаем команду запуска по умолчанию
CMD ["bash"]

