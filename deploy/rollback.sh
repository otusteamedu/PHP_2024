#!/bin/bash

# Пути для релизов и символических ссылок
CURRENT_PATH="/var/www/ikachko.ru/current"
PREVIOUS_PATH="/var/www/ikachko.ru/previous"
NGINX_CONFIG_PATH="/var/www/ikachko.ru/current/infra/nginx/ikachko.ru.conf"  # Путь к конфигу Nginx в проекте
NGINX_ENABLED_PATH="/etc/nginx/sites-enabled/ikachko.ru.conf"    # Путь к sites-enabled конфигу Nginx
NGINX_AVAILABLE_PATH="/etc/nginx/sites-available/ikachko.ru.conf"  # Путь к sites-available конфигу Nginx

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