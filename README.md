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

Initialize the application:

```shell
make init
```

Start the consumer:

```shell
make start_consumer
```

Happy coding!

## Usage Example

Make the `POST` request on `http://localhost:8080/api/emails` with the following payload:

```json
{
    "from": "sender@test.com",
    "to": "receiver@test.com",
    "text": "Hello!"
}
```

You will see the following response:

```json
{
    "id": "019492fc-4dcd-71dc-868a-ac3f53b10a82",
    "status": "pending",
    "from": "sender@test.com",
    "to": "receiver@test.com",
    "text": "Hello!"
}
```

Copy value of the `id` key and make the `GET` request on `http://localhost:8080/api/emails/{emailId}` and replace
the `emailId` placeholder with copied value of the `id` key.

You will see the following response:

```json
{
    "id": "019492fc-4dcd-71dc-868a-ac3f53b10a82",
    "status": "pending",
    "from": "sender@test.com",
    "to": "receiver@test.com",
    "text": "Hello!"
}
```

If the email (message) is consumed from the queue the `status` value will be changed to `sending`:

```json
{
    // other fields
    "status": "sending"
    // other fields
}
```

If the email was successfully sent the `status` value will be changed to `sent`:

```json
{
    // other fields
    "status": "sent"
    // other fields
}
```
