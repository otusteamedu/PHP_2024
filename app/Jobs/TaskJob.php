<?php

namespace App\Jobs;

class TaskJob extends Job
{
    /** @var string */
    public string $taskId;

    /**
     * Create a new job instance
     *
     * @return void
     */
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * Execute the job
     *
     * @return void
     */
    public function handle(): void
    {
        // Искусственное выполнение процесса
        sleep(20);

        // Сохранение результата обработки в текущий файл по указанному идентификатору
        file_put_contents(
            storage_path("app/tasks/{$this->taskId}.task"),
            json_encode([
                'id' => $this->taskId,
                'status' => 'Processed',
                'data' => [
                    'result' => rand(1, 100)
                ]
            ])
        );

        echo 'Запрос с идентификатором ' . $this->taskId . ' успешно обработан!' . PHP_EOL;
    }
}
