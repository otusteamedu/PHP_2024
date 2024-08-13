sudo cp deploy/nginx.conf /etc/nginx/conf.d/hw21.conf -f
sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/hw21.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/hw21.conf
sudo service nginx restart
sudo service php8.2-fpm restart
sudo -u www-data php app/bin/console cache:clear
sudo service supervisor restart
