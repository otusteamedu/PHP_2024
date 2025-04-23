# Базовый образ для разработки (hot-reload)
FROM node

WORKDIR /app

COPY ./app/frontend/package*.json ./

RUN npm install

COPY ./app/frontend .

EXPOSE 3000