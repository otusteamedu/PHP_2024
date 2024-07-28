# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


# 1. cp .env.example .env
# 2. docker compose up -d --build
# 3. docker compose exec php-fpm bash
# 4. composer install 
# 5. php app/Infrastructure/Console/consume.php
# 5. Пример: отправить POST запрос "http://myapp.local/create-transaction-report/" с телом

```json
{
  "dateFrom": "2024-01-03 22:00",
  "dateTo": "2024-07-03 22:00",
  "accountFrom": "7885c4dcd3888",
  "accountTo": "6685b4ccd3268",
  "transactionType": "transaction",
  "transactionStatus": "success"
}
```

