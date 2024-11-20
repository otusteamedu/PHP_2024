### Модульные тесты:

1. Проверка наличия всех обязательных полей.
Если какое-то обязательное поле отсутствует, то метод возвращает 400 с сообщением об ошибке.
2. Проверка card_number. Если card_number содержит не 16 цифр, то метод возвращает 400 с сообщением об ошибке.
3. Проверка card_holder. Если card_holder не содержит латинские символы, дефис или пробел, то метод возвращает 400 с сообщением об ошибке.
4. Проверка card_expiration. Если card_expiration не соответствует формату "мм/гг" или указывает на прошедшую дату, то метод возвращает 400 с сообщением об ошибке.
5. Проверка cvv. Если cvv не содержит 3 цифры, то метод возвращает 400 с сообщением об ошибке.
6. Проверка order_number. Если order_number содержит недопустимые символы, то метод возвращает 400 с сообщением об ошибке.
7. Проверка sum. Если sum не соответствует формату, то метод возвращает 400 с сообщением об ошибке.
8. Если все поля валидные, то метод возвращает 200.
9. Если списание средств успешно, то метод setOrderIsPaid возвращает true.
10. Если списание средств не успешно, то метод setOrderIsPaid выбрасывает исключение.

### Интеграционные тесты:

1. Связка "фронт-бэк":
   1. Если данные не прошли валидацию на бэке, то на фронте выделиться соответствующее поле красной рамкой.

2. Связка "бэк-репозиторий".
   1. После успешного списания средств и вызове метода setOrderIsPaid с правильными параметрами, метод возвращает true.
   2. После успешного списания средств и вызове метода setOrderIsPaid с неправильными параметрами, метод выбрасывает исключение.
   3. После не успешного списания средств метод setOrderIsPaid не вызывается.

### Системные тесты:

1. Проверка успешного списания средств. После получения ответа от сервиса с HTTP-кодом 200, на фронте отображается сообщение об успешной оплате.
2. Проверка неуспешного списания средств. После получения ответа от сервиса с HTTP-кодом 403, убедиться, на фронте отображается соответствующая ошибка пользователю.
3. Если сервис возвращает непредвиденный HTTP-код, удостовериться, что ошибка корректно обрабатывается на бэке и на фронте выводиться соответствующая ошибка.
