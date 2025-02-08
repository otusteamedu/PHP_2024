#!/bin/bash

# Пути для релизов и символических ссылок
CURRENT_PATH="/var/www/health-diary/current"
PREVIOUS_PATH="/var/www/health-diary/previous"

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

echo "Rollback complete! Now serving previous release."
