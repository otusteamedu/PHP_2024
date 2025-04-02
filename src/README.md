# PHP_2024 Laravel App

В папке .github/workflows содержатся файлы GitHub actions для Laravel приложения

### Установите Laravel приложение в текущую папку

### Добавьте необходимые секреты (Secrets) в GitHub репозиторий:

1. Перейдите в Settings → Secrets and variables → Actions
2. Добавьте:
- SSH_HOST – IP или домен сервера
- SSH_USERNAME – пользователь для подключения (обычно root или ubuntu)
- SSH_PRIVATE_KEY – приватный SSH-ключ для доступа к серверу
