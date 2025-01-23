#!/bin/bash

# Пути для релизов и символических ссылок
BASE_PATH="/var/www/ikachko.ru"
DEPLOY_PATH="$BASE_PATH/releases"
CURRENT_PATH="$BASE_PATH/current"
PREVIOUS_PATH="$BASE_PATH/previous"
NGINX_CONFIG_PATH="$BASE_PATH/current/infra/nginx/ikachko.ru.conf"  # Путь к конфигу Nginx в проекте
NGINX_ENABLED_PATH="/etc/nginx/sites-enabled/ikachko.ru.conf"          # Путь к sites-enabled конфигу Nginx
NGINX_AVAILABLE_PATH="/etc/nginx/sites-available/ikachko.ru.conf"          # Путь к sites-available конфигу Nginx
BASE_ENV_FILE = "$BASE_PATH/.env"


# Получаем временную метку
TIMESTAMP=$(date +'%d-%m-%Y_%H:%M:%S')

# Создаем директорию для нового релиза
NEW_RELEASE_PATH="$DEPLOY_PATH/$TIMESTAMP"
NEW_RELEASE_APP_PATH = "$NEW_RELEASE_PATH/app"
NEW_RELEASE_ENV_ENV_FILE = "$NEW_RELEASE_APP_PATH/app/.env.local"
mkdir -p $NEW_RELEASE_PATH

# Копируем или клонируем проект в новую директорию
git clone git@gitlab.com:myown9174003/bills_helper.git $NEW_RELEASE_PATH

if [ -L "$NEW_RELEASE_APP_PATH" ]; then
  cp $BASE_ENV_FILE $NEW_RELEASE_ENV_ENV_FILE
  cd $NEW_RELEASE_APP_PATH
  composer install
  cd $BASE_PATH
fi

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