### API Task

Установка. В Makefile последовательно запустить:

- init
- composer-install

Сервер RabbitMQ:

- http://mysite.local:15672

API endpoints:
- POST: http://mysite.local/api/v1/tasks
- GET: http://mysite.local/api/v1/tasks
- GET: http://mysite.local/api/v1/tasks/{id}
- DELETE: http://mysite.local/api/v1/tasks/{id}
- PUT: http://mysite.local/api/v1/tasks/{id}
- PATCH: http://mysite.local/api/v1/tasks/{id}

Payload (json):
- name: Ivan
- email: ivan@test.com
