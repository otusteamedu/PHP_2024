    sudo -u www-data composer install -q
    sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/staging.conf -f
    sudo service php8.3-fpm restart
    sudo -u www-data sed -i -- "s|%SERVER_URL%|$1|g" .env
    sudo -u www-data sed -i -- "s|%DATABASE_HOST%|$2|g" .env.test
    sudo -u www-data sed -i -- "s|%DATABASE_USER%|$3|g" .env.test
    sudo -u www-data sed -i -- "s|%DATABASE_PASSWORD%|$4|g" .env.test
    sudo -u www-data sed -i -- "s|%DATABASE_NAME%|$5|g" .env.test
    sudo -u www-data php bin/console doctrine:migrations:migrate -n --env=test --no-interaction
    sudo -u www-data sed -i -- "s|%RABBITMQ_HOST%|$6|g" .env
    sudo -u www-data sed -i -- "s|%RABBITMQ_USER%|$7|g" .env
    sudo -u www-data sed -i -- "s|%RABBITMQ_PASSWORD%|$8|g" .env
    sudo service supervisor restart