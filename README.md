# Media Monitoring Application

## Описание

Media Monitoring Application — это консольное и веб-приложение, которое позволяет:
- Создавать записи новостей на основе переданного URL.
- Получать список всех созданных новостей.
- Формировать и сохранять сводный отчет в виде HTML-файла на основе выбранных новостей.

## Требования

- PHP 8.3 или выше
- PostgreSQL
- Composer

## Установка

1. **Клонируйте репозиторий:**

    ```sh
    git clone https://github.com/your-username/media-monitoring.git
    cd media-monitoring
    ```

2. **Установите зависимости с помощью Composer:**

    ```sh
    composer install
    ```

3. **Настройте переменные окружения:**

   Создайте файл `.env` на основе примера `.env.example` и настройте параметры подключения к базе данных:

    ```env
    APP_SECRET=your_secret_key
    DATABASE_URL="postgresql://your_username:your_password@localhost:5432/your_database_name"
    DATABASE_HOST="localhost"
    DATABASE_PORT="5432"
    DATABASE_NAME="your_database_name"
    DATABASE_USER="your_username"
    DATABASE_PASSWORD="your_password"
    ```
   
4. **Сделайте исполняем файл для работы в терминале:**

    ```sh
   chmod +x bin/console
   ```
## Запуск приложения

### Через консольные команды

1. **Создание новости:**

    ```sh
    ./bin/console app:create-news https://example.com/news-article
    ```

   Пример ответа:

    ```json
    {"id":1}
    ```

2. **Получение списка новостей:**

   Для получения списка новостей и формирования отчетов используется веб-интерфейс.

### Через HTTP-запросы

1. **Настроить файл `hosts` на Windows:**

   Откройте файл `C:\Windows\System32\drivers\etc\hosts` с правами администратора и добавьте следующую строку:

    ```
    127.0.0.1   mysite.local
    ```

### Примеры запросов через `curl`

1. **Создание новости:**

    ```sh
    curl -X POST http://mysite.local/create-news -H "Content-Type: application/json" -d '{"url": "https://stackoverflow.com/questions/48090943/symfony-4-you-have-requested-a-non-existent-service"}'
    ```

   Пример ответа:

    ```json
    {"id":1}
    ```

2. **Получение списка новостей:**

    ```sh
    curl -X GET http://mysite.local/news-list
    ```

   Пример ответа:

    ```json
    [
        {"id":1,"date":"2023-10-10 12:34:56","url":"https://stackoverflow.com/questions/48090943/symfony-4-you-have-requested-a-non-existent-service","title":"Symfony 4: You have requested a non-existent service"}
    ]
    ```

3. **Формирование сводного отчета:**

    ```sh
    curl -X POST http://mysite.local/generate-report -H "Content-Type: application/json" -d '{"ids":[1]}'
    ```

   Пример ответа:

    ```json
    {"report_url":"/data/mysite.local/reports/report_123456789.html"}
    ```

## Структура проекта
