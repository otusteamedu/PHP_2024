# Приложение асинхронной обработки

### Для запуска приложения необходимо:

1. Создать файл с переменными окружения `.env` скопировав файл `.env.example`
2. Выполнить команду из корня папки `docker-compose up --build`

#### Чтобы увидеть все сообщения в очереди на генерацию нужно выполнить команду: 
`docker exec -it {APP_NAME}_php php bin/console app:queue:messages app:report:finance:make`

#### Чтобы увидеть все сообщения в очереди на отправку нужно выполнить команду:
`docker exec -it {APP_NAME}_php php bin/console app:queue:messages app:report:finance:send`