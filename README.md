## Redis

### Add event:

docker exec -it app php /app/public/index.php add '{priority:`val`, conditions: {`key` = `val`, ...}, event: {`event`}}'

    docker exec -it app php /app/public/index.php add '{priority: 1000, conditions: {param1 = 1}, event: {::event1::}}'
    // 1
    docker exec -it app php /app/public/index.php add '{priority: 2000, conditions: {param1 = 1, param2 = 2}, event: {::event2::}}'
    // 1
    docker exec -it app php /app/public/index.php add '{priority: 3000, conditions: {param1 = 1, param2 = 2}, event: {::event3::}}'
    // 1

### Find event:

docker exec -it app php /app/public/index.php get '{params: {`key` = `val`, ...}}'

    docker exec -it app php /app/public/index.php get '{params: {param1 = 1, param2 = 2}}'
    // ::event3000::

### Clear events:

    docker exec -it app php /app/public/index.php clear
    // 1
