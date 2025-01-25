#!/bin/bash

# Пути для релизов и символических ссылок
CURRENT_PATH="/var/docker/cicd_practice/current"
PREVIOUS_PATH="/var/docker/cicd_practice/previous"
NGINX_ENABLED_PATH="/etc/nginx/sites-enabled/default"    # Путь к sites-enabled конфигу Nginx
NGINX_AVAILABLE_PATH="/etc/nginx/sites-available/default"  # Путь к sites-available конфигу Nginx

# Проверяем, существует ли символическая ссылка на предыдущую версию
if [ ! -L "$PREVIOUS_PATH" ]; then
    echo "No previous release found. Rollback aborted."
    exit 1
fi

# Получаем путь к предыдущему релизу
PREVIOUS_RELEASE=$(readlink -f $PREVIOUS_PATH)


# Обновляем символическую ссылку на предыдущую версию как текущую
rm -f $CURRENT_PATH
ln -s $PREVIOUS_RELEASE $CURRENT_PATH

# Удаляем ссылку на предыдущую версию, так как мы вернулись на нее
rm -f $PREVIOUS_PATH

# Перезагружаем Nginx, чтобы он начал обслуживать предыдущую версию
sudo systemctl reload nginx
sudo systemctl reload php8.3-fpm

echo "Rollback complete! Now serving previous release."