# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


## Инструкция

1. .env.example -> .env
2. установить значения RABBIT_USER и RABBIT_PASSWORD
3. `docker-compose up -d --build` 
4. отправить POST запрос 

` curl --location 'http://localhost/index.php' \
--form 'account="111"' \
--form 'dateFrom="2024-01-01"' \
--form 'dateTo="2024-05-01"' \
--form 'email="test@test.ru"' `

5. запустить consumer
`docker exec -it app php public/index.php consumer`

