На старой схеме представлен реальный модуль на Битриксе.
На схеме отсутствует 2 служебных класса:
- DataManager для описания таблицы в БД
- Controller для взаимодействия с front частью
Это модуль отзывов на товары в интернет-магазине. Модуль умеет:
1. Добавлять, изменять и удалять отзывы. Хранение в БД MySQL
2. Менять статус отзыва - На модерации / Опубликован / Отклонен
3. Считать оценку за товар. Суммировать все оценки и делить на кол-во отзывов
4. Получать все отзывы и оценку на конкретный товар
5. Проверка, что один пользователь может оставить один отзыв на конкретный товар
6. Только пользователь купивший товар может оставлять на него отзыв
7. Отправка служебного письма, когда приходит новый отзыв

На новой схеме старался отразить данный модуль с тем же набором функций на чистой архитектуре.