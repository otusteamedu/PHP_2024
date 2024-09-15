### Initialize elastic data :

    docker exec -it app php /app/public/index.php init

### Query elastic:

    docker exec -it app php /app/public/index.php query [prop]=[val] [prop]=[val]

Query examples:

    docker exec -it app php /app/public/index.php query title=рыцори 
    docker exec -it app php /app/public/index.php query sku=031
    docker exec -it app php /app/public/index.php query price_min=5188 price_max=6188
