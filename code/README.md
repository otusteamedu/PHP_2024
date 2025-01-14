Приложение сразу подключается к удаленному серверу docker, поэтому предварительно регистрируемся на https://www.elastic.co

### Загрузка данных в elastic :

    docker exec -it app php app.php init

### Формат запроса данных:

    docker exec -it app php app.php query [property]=[value] [propeprty_name=min_value:max_value]

### Примеры запросов:

    docker exec -it app php app.php query title=Вино красное 
    docker exec -it app php app.php query sku=500-004
    docker exec -it app php app.php query sku=500-004 price=1000:1500