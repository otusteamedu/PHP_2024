# PHP_2024

## Инструкция

### 1. composer install
### 2. docker compose up -d
### 3. В контейнере php выполнить следующие команды:
```
cd public
php index.php start
```
### 4. Отправить POST запрос на http://localhost:
>Например через Postman

Параметры:
```
dateFrom: string
dateTo: string
```