<?php

namespace Builov\RedisApp;

class View
{
    public static function display($data): void
    {
        $conditionsListOptions = '';
        foreach ($data['conditions'] as $condition) {
            $conditionsListOptions .= '<option value="' . $condition . '">' . $condition . '</option>';
        }

        $messages = '';

        if (!empty($data['messages'])) {
            foreach ($data['messages'] as $message) {
                $messages .= '<p class="mt-3">' . $message . '</p>';
            }

        }

        $html = <<<HTML

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redis app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

  </head>
  <body class="pt-5 pb-5">
  
  <div class="container">
  
    {$messages}
  
    <h2 class="mt-5">Создать событие:</h2>
  
    <form name="create-event-form" method="post" class="mb-5">
      <input type="hidden" name="form-name" value="create-event-form">
      
      <div class="row mb-4">
        <div class="col">
          <label for="event-condition-name[1]" class="form-label">Критерий возникновения события #1</label>
          <input type="text" class="form-control"  name="event-condition-name[1]" id="event-condition-name[1]" />
        </div>
        <div class="col">
          <label for="event-condition-value[1]" class="form-label">Значение критерия возникновения события #1</label>
          <input type="text" class="form-control"  name="event-condition-value[1]" id="event-condition-value[1]" />
        </div>
      </div>
    
      <div class="row mb-4">
        <div class="col">
          <label for="event-condition-name[2]" class="form-label">Критерий возникновения события #2</label>
          <input type="text" class="form-control"  name="event-condition-name[2]" id="event-condition-name[2]" />
        </div>
        <div class="col">
          <label for="event-condition-value[2]" class="form-label">Значение критерия возникновения события #2</label>
          <input type="text" class="form-control"  name="event-condition-value[2]" id="event-condition-value[2]" />
        </div>
      </div>
      
      <div class="mb-4">
        <label for="event-priority" class="form-label">Приоритетность события</label>
        <input type="number" name="event-priority" class="form-control" />
        <div class="form-text">Целое число</div>
      </div>
    
      <div class="mb-4">
        <label for="event-description" class="form-label">Событие</label>
        <textarea name="event-description" rows="3" class="form-control"></textarea>
      </div>
    
        <button type="submit" class="btn btn-primary">Создать событие</button>
    </form>
    
    <h2 class="mt-5">Получить событие</h2>
    
    <form name="get-event-form" method="post">
      <input type="hidden" name="form-name" value="get-event-form">
      
      <div class="mb-4">
          <label for="conditions[]" class="form-label">Выберите условие/я возникновения события:</label>
          <select name="conditions[]" class="form-select" multiple>
              {$conditionsListOptions}
          </select>
      </div>
      
       <button type="submit" class="btn btn-primary">Получить событие</button>
    </form>
    
    <form name="clear-db" method="post" class="mt-5">
        <input type="hidden" name="form-name" value="clear-db">      
        <button type="submit" class="btn btn-primary">Очистить БД</button>
    </form>

  </div>
  
</body>
</html>

HTML;

        header('Content-Type: text/html; charset=utf-8');
        echo $html;
    }
}