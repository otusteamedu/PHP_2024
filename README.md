# Проверка работы команды

Команда проверки суммы запускается с передачей двух числовых аргументов `sum.sh`

Команды вывода часто встречающихся городов запускается с передачей файла с таблицей `cities.sh users.list`

Если у вас ОС Linux, то можно запустить так:

```shell
  sum.sh 1.5 -7
  cities.sh users.list
```

Если у вас ОС Windows, то можно запустить через Docker контейнер:

1. Создание образа
    ```shell
      docker build -t script-alpine .
    ```

2. Выполнение команд
    ```shell
      docker run --rm -v ${PWD}:/app script-alpine ./sum.sh 1.5 -7
      docker run --rm -v ${PWD}:/app script-alpine ./cities.sh users.list
    ```

3. Удаление образа
    ```shell
      docker rmi -f script-alpine
    ```
