# PHP + Nginx + Composer + ElasticSearch в Docker
Этот проект представляет собой окружение для разработки PHP-приложений с использованием **Docker, Nginx, PHP-FPM и Composer**.

## 📂 Структура проекта

context/                  # Файлы конфигурации для контейнеров <BR>
project/htdocs/           # Корневая папка проекта (PHP-код)

## 🛠 Установка и запуск

  ```sh
  docker-compose up --build
  ```
  ```sh
  docker-compose run --rm composer install
  -- docker-compose run --rm composer require some/package
  ```

  ```sh
docker exec -it <container_name\or_id> bash
  ```

