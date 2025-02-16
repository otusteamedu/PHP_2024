# Консольные команды

## Создание события в Redis
```bash
php index.php add '{"priority":1000,"conditions":{"param1":1},"event":"::event::"}'
php index.php add '{"priority":2000,"conditions":{"param1":2, "param2":2},"event":"::event::"}'
php index.php add '{"priority":3000,"conditions":{"param1":1, "param2":2},"event":"::event::"}'
```