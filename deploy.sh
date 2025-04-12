sudo cp deploy/nginx.conf /etc/nginx/conf.d/asyncbank.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/asyncbank.conf
sudo service nginx restart
sudo -u www-data composer install -q
sudo service php8.4-fpm restart
sudo cp .env.deploy .env -f
sudo -u www-data sed -i -- "s|%DATABASE_HOST%|$2|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_USER%|$3|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_PASSWORD%|$4|g" .env
sudo -u www-data sed -i -- "s|%DATABASE_NAME%|$5|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_HOST%|$6|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_USER%|$7|g" .env
sudo -u www-data sed -i -- "s|%RABBITMQ_PASSWORD%|$8|g" .env
sudo -u www-data php artisan optimize
sudo -u www-data php artisan migrate

echo "🔍 Запуск unit-тестов..."
sudo -u www-data ./vendor/bin/phpunit tests/Unit
if [ $? -ne 0 ]; then
  echo "❌ Unit-тесты не прошли! Деплой остановлен."
  exit 1
fi

