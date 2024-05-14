# PHP_2024

1. Запускаем контейнеры 


    `docker-compose up -d --build`

2. Контейнеры запущены, база наполнена, тестим следующими командами (паттерн - Active Record):
   
    2.1. Добавляем запись (1 аргумент insert) id = 'film1' , name = 'DMB'
   
        `docker exec -it php php app/index.php insert film1 DMB`

    2.2. Удаляем запись (1 аргумент delete) id = 'film1'
   
        `docker exec -it php php app/index.php delete film1`
   
    2.3. Обновляем запись (1 аргумент update) id = 'film2' , name = 'DMB_2'
   
        `docker exec -it php php app/index.php update film1 DMB_2`
   
    2.4. *Выбираем все записи из таблицы (1 аргумент selectAll)
   
        `docker exec -it php php app/index.php selectAll`
   
    2.5. *Выбираем одну запись по id (1 аргумент selectOne), реализована Lazy Loading со связанной таблицей
   
        `docker exec -it php php app/index.php selectOne duna_2`