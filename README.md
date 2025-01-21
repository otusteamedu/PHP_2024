# Проверка работы

1. Создание образа
    ```shell
      docker-compose up -d
    ```

2. Выполнение команды
    ```shell
      docker exec -it php_app php index.php
    ```

3. Удаление контейнера
    ```shell
      docker-compose down
    ```
