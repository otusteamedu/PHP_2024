docker stop php-telegram-bot-prod postgres-telegram-bot-prod nginx-telegram-bot-prod rabbitmq-telegram-bot-prod supervisor-telegram-bot-prod
docker rm php-telegram-bot-prod postgres-telegram-bot-prod nginx-telegram-bot-prod rabbitmq-telegram-bot-prod supervisor-telegram-bot-prod

sudo -u www-data sed -i -- "s|%APP_ENV%|$1|g" .env
sudo -u www-data sed -i -- "s|%SERVER_NAME%|$2|g" .env

docker compose -f docker-compose.yml up -d
docker exec -i php-telegram-bot-prod sh -c "APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear"
docker compose -f docker-compose.yml up -d
