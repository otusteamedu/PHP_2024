### Queue Task

Установка. В Makefile последовательно запустить:

- init
- composer-install

Сервер RabbitMQ:

- http://mysite.local:15672

Сервер почтового клиента:

- http://mysite.local:8025

API endpoint (POST):

- http://mysite.local/api/v1/report

Payload (form-data):

- email: test@test.com
- startDate: 2024-01-01
- endDate: 2024-01-31
