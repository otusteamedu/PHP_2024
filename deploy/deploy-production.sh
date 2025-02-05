docker stop php-telegram-bot-prod postgres-telegram-bot-prod nginx-telegram-bot-prod rabbitmq-telegram-bot-prod supervisor-telegram-bot-prod
docker rm php-telegram-bot-prod postgres-telegram-bot-prod nginx-telegram-bot-prod rabbitmq-telegram-bot-prod supervisor-telegram-bot-prod

sudo -u www-data sed -i -- "s|%APP_ENV%|$1|g" .env
sudo -u www-data sed -i -- "s|%SERVER_NAME%|$2|g" .env

docker compose -f docker-compose.yml up -d
docker exec -i php-telegram-bot-prod sh -c "APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear"
docker compose -f docker-compose.yml up -d
docker exec -i php-telegram-bot-prod sh -c "php bin/console doctrine:migrations:migrate --no-interaction"

docker exec -i php-telegram-bot-prod sh -c "composer update"
docker exec -i php-telegram-bot-prod sh -c "composer install"
docker exec -i php-telegram-bot-prod sh -c "yarn update"
docker exec -i php-telegram-bot-prod sh -c "yarn install"
docker exec -i php-telegram-bot-prod sh -c "chmod 777 var -R"

docker exec -i php-telegram-bot-prod sh -c "php bin/console doctrine:migrations:migrate --no-interaction"
