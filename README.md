# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

Запуск (без сборки)
--------------------
Права доступа:
```shell
sudo chmod +x ./sum.sh ./cities_top.sh
```
Калькулятор:
```shell
./sum.sh 5 4
```
Топ 3 городов:
```shell
./cities_top.sh ./cities.txt
```

Сборка контейнера
--------------------
```shell
docker build -t hw2 .
```

Запуск
--------------------
Калькулятор:
```shell
docker run -it hw2 /sum.sh 4 4
```
Топ 3 городов:
```shell
docker run -it hw2 /cities_top.sh /cities.txt
```
