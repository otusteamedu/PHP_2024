sudo cp deploy/nginx.conf /etc/nginx/conf.d/battleship.conf -f
sudo service nginx restart
sudo systemctl restart php8.3-fpm.service