# Описание работы

Сложность алгоритма получается O(n+m).
Потому что в худшем случае придется обойти по порядку оба массива.

LeetCode данное решение принял.

# Проверка работы

1. Создание образа
    ```shell
      docker compose up -d
    ```

2. Выполнение команды. Представлено несколько вариантов проверок.
    ```shell
      docker exec -it otus-php-app php index1.php
    ```
    ```shell
      docker exec -it otus-php-app php index2.php
    ```
    ```shell
      docker exec -it otus-php-app php index3.php
    ```
    ```shell
      docker exec -it otus-php-app php index4.php
    ```
    ```shell
      docker exec -it otus-php-app php index5.php
    ```
    ```shell
      docker exec -it otus-php-app php index6.php
    ```
    ```shell
      docker exec -it otus-php-app php index7.php
    ```
    ```shell
      docker exec -it otus-php-app php index8.php
    ```

3. Удаление контейнера
    ```shell
      docker compose down
    ```
