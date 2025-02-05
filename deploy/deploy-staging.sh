docker stop php-telegram-bot-dev postgres-telegram-bot-dev nginx-telegram-bot-dev rabbitmq-telegram-bot-dev supervisor-telegram-bot-dev
docker rm php-telegram-bot-dev postgres-telegram-bot-dev nginx-telegram-bot-dev rabbitmq-telegram-bot-dev supervisor-telegram-bot-dev

sudo -u www-data sed -i -- "s|%APP_ENV%|$1|g" .env
sudo -u www-data sed -i -- "s|%SERVER_NAME%|$2|g" .env

docker compose -f docker-compose.staging.yml up -d

docker exec -i php-telegram-bot-dev sh -c "composer install"
docker exec -i php-telegram-bot-dev sh -c "yarn install"
docker exec -i php-telegram-bot-dev sh -c "sudo chmod 777 var -R"

docker restart php-telegram-bot-dev supervisor-telegram-bot-dev

docker exec -i php-telegram-bot-dev sh -c "php bin/console doctrine:migrations:migrate --no-interaction"
docker exec -i php-telegram-bot-dev sh -c "php bin/console doctrine:database:create -n --env=test --no-interaction"
docker exec -i php-telegram-bot-dev sh -c "php bin/console doctrine:migrations:migrate -n --env=test --no-interaction"
