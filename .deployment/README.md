# Деплой

1) Для деплоя необходимо установить утилиту `ansible`.
2) Запуск деплоя на прод осуществляется командой ниже. Обязательно перейти в корневую директорию проекта. Переменные для .env файла берутся из отдельного приватного репозитория на gitlab.

```shell
ansible-playbook .deployment/ansible/playbook/deploy.yaml
```

3) Роллбек выполняется командой ниже

```shell
ansible-playbook .deployment/ansible/playbook/rollback.yaml
```
