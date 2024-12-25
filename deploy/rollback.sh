    sudo sed -i -- "s|%SERVER_URL%|$1|g" tests/Acceptance.suite.yml
    sudo sed -i -- "s|%SERVER_URL%|$1|g" deploy/nginx.conf
    sudo cp deploy/nginx.conf /etc/nginx/conf.d/production.conf -f
    sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/production.conf -f
    sudo service nginx restart
    sudo service php8.3-fpm restart
    sudo -u www-data php bin/console cache:clear
    sudo service supervisor restart