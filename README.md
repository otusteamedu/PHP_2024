# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

поставить миграции

получение всех записей 
````
http://localhost:8876/all
````
реализация RowDataGateway
````
http://localhost:8876/create
http://localhost:8876/update
````
роутинг
````
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideosRowDataGatewayController;

Route::get('all', VideosController::class)->name('getAll');
Route::get('create', [VideosRowDataGatewayController::class, 'create'])->name('rowDataGateway');
Route::get('update', [VideosRowDataGatewayController::class, 'update'])->name('rowDataGateway');
