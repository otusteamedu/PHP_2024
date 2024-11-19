# Используем базовый образ Ubuntu
FROM ubuntu:latest

# Кладем файлы в tmp
COPY ./sum.sh /tmp/sum.sh
COPY cities.txt /tmp/cities.txt
COPY ./sort.sh /tmp/sort.sh

# Устанавливаем команду запуска по умолчанию
CMD ["bash"]

