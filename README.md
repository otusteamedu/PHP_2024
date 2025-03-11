# Homework 20

1. **Запустите контейнеры:**

```bash
docker-compose up -d --build
```

2. **Инициализируйте БД:**

```bash
docker-compose exec app php bin/console doctrine:database:create
docker-compose exec app php bin/console make:migration
docker-compose exec app php bin/console doctrine:migrations:migrate
```

3. **Запустите обработчик очереди:**

```bash
docker-compose exec app php bin/console messenger:consume async
```

4. **Отправьте запрос через веб-форму:**
- Откройте http://localhost/statement/request.
- Введите даты (например, 2025-03-01 и 2025-03-10).
- Нажмите Generate Statement.

5. **Проверьте Telegram:**

Через 5 секунд вы получите уведомление:

```
Statement generated for 2025-03-01 to 2025-03-10
```

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus
