# Проверка работы

1. Создание образа
    ```shell
      docker-composer -p otus-composer-app up -d
    ```

2. Выполнение команды
    ```shell
      docker exec -it php_app php index.php
    ```
