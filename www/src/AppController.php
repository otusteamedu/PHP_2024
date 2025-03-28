<?php
declare(strict_types=1);

namespace Builov\RedisApp;

class AppController
{
    private DbConnector $dbConnection;

    public function __construct() {
        $this->dbConnection = new RedisConnector();
    }

    public function run(): void
    {
        $event = new EventModel($this->dbConnection);

        $data['messages'] = [];

        if (!empty($_POST)) {
            array_walk_recursive( $_POST, function(&$value, $key) {
                $value = htmlspecialchars($value);
            });

            if ($_POST['form-name'] === 'create-event-form') {
                try {
                    $eventDescription = $event->create($_POST['event-condition-name'], $_POST['event-condition-value'], (int)$_POST['event-priority'], $_POST['event-description']);

                    $data['messages'][] = 'Добавлено событие "' . $eventDescription . '".';
                } catch (\Exception $e) {
                    $data['messages'][] = $e->getMessage();
                }
            }

            if ($_POST['form-name'] === 'get-event-form') {
                if (!empty($_POST['conditions'])) {
                    $matched_event = $event->get($_POST['conditions']);

                    if (empty($matched_event)) {
                        $data['messages'][] = 'Подходящего события не найдено.';
                    } else {
                        $data['messages'][] = 'Событие: ' . $matched_event['event'];
                    }
                } else {
                    $data['messages'][] = 'Пожалуйста, укажите критерии поиска.';
                }
            }

            if ($_POST['form-name'] === 'clear-db') {
                if ($event->deleteAll()) {
                    $data['messages'][] = 'База данных очищена.';
                }
            }
        }

        $data['conditions'] = $event->getExistingConditions();

        View::display($data);
    }
}
