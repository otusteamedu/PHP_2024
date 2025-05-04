#!/bin/sh

# Если composer.json отсутствует, создаем его вручную
if [ ! -f composer.json ]; then
    cat > composer.json <<EOF
{
  "name": "project/app",
  "description": "My PHP Project",
  "version": "1.0.0",
  "require": {
    "php": "^8.0"
  },
  "minimum-stability": "stable",
  "prefer-stable": true
}
EOF
fi

# Устанавливаем зависимости
composer install --no-progress --no-suggest

exec "$@"