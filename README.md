# OTUS 2024

php artisan storage:link

1. Всегда есть единые сущности Entity в Domain, с которыми работают все Request и Response в Application, 
но также  и у каждого хранилища есть отдельные Model (DB, Elasticsearch и тп)
2. Преобразование Model в Entity происходит в репозиториях? (нужно вернуть список с пагинацией, какую сущность возвращать?)
3. Есть встроенные Request и Response - можно их использовать в контроллере 
4. Если хочу использовать Cache/Log/Session/Cookie/Event/Job, обращаться к сервисам в UseCase через интерфейсы? 
5. На каждый эндпоинт отдельный контроллер __invoke 
6. Все ступени вызовов описываются через UseCase (считать как сервис?)
7. Класс Helper со статическими методами хранится в Infrastructure и там же вызывается где нужно?
8. Нужно ли Date (Carbon) кидать в ValueObject
9. Factory в Infrastructure создают Domain/Entity, в то время как встроенные Factory работают с хранилищами
10. Если нужно вернуть Посты с комментариями, то Посты имеют массив комментариев в Domain/Entity 

Запрос
1. Проверка Middleware
2. Проверка Request
3. Контроллер
4. Контроллер -> UseCase
5. UseCase -> Infrastructure через интерфейсы
6. Infrastructure работает с БД, API
7. Контроллер возвращает встроенные Resource


