# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Installation

Create the `.env` file and modify for your needs:

```shell
cp .env.dist .env
```

Start the containers:

```shell
make up
```

Jump into the `php-fpm` container shell:

```shell
make shell
```

Install the `composer` dependencies:

```shell
composer install
```

Happy coding!

## Usage Example

### Sync statement generation process

Make the `POST` request on `http://localhost:8080/api/statements` with the following payload:

```json
{
    "user_id": 1,
    "date_from": "2023-01-01",
    "date_to": "2024-01-01"
}
```

You will see the following response:

```json
{
    "success": true,
    "message": "The statement was generated successfully"
}
```

### Async statement generation process

Jump into the `php-fpm` container shell:

```shell
make shell
```

Start the `generate_statement` consumer (do not close the tab with running terminal):

```shell
php bin/console queue:consumer:start generate_statement
```

You will se the following message:

```shell
Consumer [queue.consumer.generate_statement] started
```

> To make sure that consumer is running, you could check the `RabbitMQ`
> dashboard's ["Connections"](http://localhost:15672/#/connections)
> section

Make the `POST` request on `http://localhost:8080/api/async/statements` with the following payload:

```json
{
    "user_id": 1,
    "date_from": "2023-01-01",
    "date_to": "2024-01-01"
}
```

You will see the following response:

```json
{
    "success": true,
    "message": "The statement generation was successfully scheduled"
}
```

Check the terminal's tab, where you started the `generate_statement` consumer, you will see there the consumed message(
s):

```shell
Consumer [queue.consumer.generate_statement] started
Consumed message: {"user_id":1,"date_from":"2023-01-01","date_to":"2024-01-01"}
```

App provides the nullable statement generator and nullable notification transport, if they
are used (they are used by default), you are able to check the logs in the `var/log` directory to confirm that app is
working. 
