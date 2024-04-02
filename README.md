# PHP_2024



**Запуск сервера**
1) Запускаем `docker-compose up -d --build`


**Запуск клиента**
1) Монтируем образ командой
   
   `docker build -t otus-php_client ./docker/`
   
2)  Запускаем контейнер и командную строку

`docker run --name php_client -it --network=otus_php_app --volumes-from php_server otus-php_client bash`

3) Запускаем приложение `php app.php client`