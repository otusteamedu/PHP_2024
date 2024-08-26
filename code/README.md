# PHP чат на сокетах

client и server side для обмена сообщениями

## Установка

```sh
docker compose up -d --build
```

1. Добавляем свой config.ini по примеру [config.ini-default](./src/config.ini-default)

<ol start="2">
    <li>
        Для удобства открываем консоль для server-side и запускаем
    </li>
</ol>

```sh
php app.php server
```

<ol start="3">
    <li>
        Далее открываем консоль для client-side, запускам и мы готовы отправлять и получать сообщения
    </li>
</ol>

```sh
php app.php client
```