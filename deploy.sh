#!/bin/bash

# Пути для релизов и символических ссылок
DEPLOY_PATH="/var/www/cicd-makhov-2025/releases" # Все наши релизы
CURRENT_PATH="/var/www/cicd-makhov-2025/current" # Текущий релиз
PREVIOUS_PATH="/var/www/cicd-makhov-2025/previous" # Прошлый релиз
NGINX_CONFIG_PATH="/var/www/cicd-makhov-2025/current/infra/nginx/default"  # Путь к конфигу Nginx в проекте
NGINX_ENABLED_PATH="/etc/nginx/sites-enabled/default" # Путь к sites-enabled конфигу Nginx
NGINX_AVAILABLE_PATH="/etc/nginx/sites-available/default" # Путь к sites-available конфигу Nginx

# Получаем временную метку
TIMESTAMP=$(date +'%d-%m-%Y_%H:%M:%S')

# Создаем директорию для нового релиза
NEW_RELEASE_PATH="$DEPLOY_PATH/$TIMESTAMP"
mkdir -p $NEW_RELEASE_PATH

# Копируем или клонируем проект в новую директорию
git clone git@gitlab.com:Slava_Makhov/cicd-makhov-2025.git $NEW_RELEASE_PATH

# Если текущая версия существует, сохраняем её как предыдущую
if [ -L "$CURRENT_PATH" ]; then
    PREVIOUS_RELEASE=$(readlink -f $CURRENT_PATH)
    rm -f $PREVIOUS_PATH
    ln -s $PREVIOUS_RELEASE $PREVIOUS_PATH
fi

# Удаляем старый символический линк и создаем новый для текущей версии
rm -f $CURRENT_PATH
ln -s $NEW_RELEASE_PATH $CURRENT_PATH

# Удаляем старый символический линк на конфиг Nginx и создаем новый
if [ -L "$NGINX_ENABLED_PATH" ]; then
    sudo rm -f $NGINX_ENABLED_PATH
fi

if [ -L "$NGINX_AVAILABLE_PATH" ]; then
    sudo rm -f $NGINX_AVAILABLE_PATH
fi

sudo ln -s $NGINX_CONFIG_PATH $NGINX_ENABLED_PATH
sudo ln -s $NGINX_CONFIG_PATH $NGINX_AVAILABLE_PATH

# Удаляем все старые релизы, кроме последних 5
RELEASES_COUNT=5
cd $DEPLOY_PATH
RELEASES=$(ls -dt */ | tail -n +$(($RELEASES_COUNT + 1)))

if [ -n "$RELEASES" ]; then
  echo "Deleting old releases..."
  for RELEASE in $RELEASES; do
    rm -rf "$DEPLOY_PATH/$RELEASE"
  done
else
  echo "No old releases to delete."
fi

echo "Deployment complete! New release is now active."
