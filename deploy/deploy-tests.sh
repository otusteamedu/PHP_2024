docker exec -i php-telegram-bot-dev sh -c "php vendor/bin/codecept run"

docker stop php-telegram-bot-dev postgres-telegram-bot-dev nginx-telegram-bot-dev rabbitmq-telegram-bot-dev supervisor-telegram-bot-dev
docker rm php-telegram-bot-dev postgres-telegram-bot-dev nginx-telegram-bot-dev rabbitmq-telegram-bot-dev supervisor-telegram-bot-dev
