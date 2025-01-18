FROM nginx:latest

# Копируем конфигурацию Nginx
COPY balanser.conf /etc/nginx/nginx.conf

# Копируем код приложения
COPY ./code /var/www/html

EXPOSE 80
