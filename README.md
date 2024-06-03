# PHP_2024

Разрабатываем часть интернет-ресторана. Продаёт он фаст-фуд.

1. Стратегия будет отвечать за генерацию продукта: бургер, сэндвич или хот-дог
2. При готовке каждого типа продукта Шаблонный метод будет добавлять составляющие к базовому продукту либо по рецепту, либо по пожеланию клиента (салат, лук, перец и т.д.)
3. Наблюдатель будет проходить по статусам приготовления и отправлять оповещения о том, что изменился статус приготовления продукта.
4. Строитель используется для формирования событий до и после шагов готовки. Например, если бургер не соответствует стандарту, пост событие утилизирует его.
5. С помощью Адаптера заставим магазин готовить пиццу
6. Все сущности должны по максимуму генерироваться через DI.

Заказ (http-запрос, инфра) -> 1 из стратегий (инфра) -> готовка (UseCase, App) -> Продукт (Domain)